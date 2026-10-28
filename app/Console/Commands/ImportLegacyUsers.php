<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class ImportLegacyUsers extends Command
{
    protected $signature = 'legacy:import-users
        {--file= : Caminho absoluto do arquivo JSON de origem}';

    protected $description = 'Importa usuários legados de um JSON para a tabela users, com validações e preservação de IDs.';

    public function handle(): int
    {
        $file = $this->option('file')
            ?: storage_path('app/private/legacy-imports/usuarios.json');

        if (! is_file($file) || ! is_readable($file)) {
            $this->error("Arquivo não encontrado ou sem permissão de leitura: {$file}");

            return self::FAILURE;
        }

        try {
            $records = json_decode(
                file_get_contents($file),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            $this->error('O JSON não pôde ser lido: '.$e->getMessage());

            return self::FAILURE;
        }

        if (! is_array($records) || count($records) === 0) {
            $this->error('O arquivo precisa conter uma lista JSON não vazia de usuários.');

            return self::FAILURE;
        }

        if (DB::table('users')->exists()) {
            $this->error('A tabela users não está vazia. A importação foi cancelada para evitar duplicações ou sobrescritas.');

            return self::FAILURE;
        }

        try {
            [$ids, $legacyPasswords, $generatedPasswords] = $this->validateRecords($records);
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        DB::transaction(function () use ($records): void {
            $rows = [];

            foreach ($records as $record) {
                $legacyPassword = $record['senha'] ?? null;
                $hasLegacyPassword = is_string($legacyPassword) && trim($legacyPassword) !== '';

                $email = $record['email'] ?? null;
                if ($email !== null) {
                    $email = trim((string) $email);
                    if ($email === '') {
                        $email = null;
                    }
                }

                $rows[] = [
                    'id' => (int) $record['id'],
                    'login' => trim((string) $record['login']),
                    // Hashes legados não são convertidos diretamente; a autenticação compatível será tratada separadamente.
                    // Sem senha no dump de teste, cria-se um hash moderno de valor aleatório desconhecido.
                    'password' => $hasLegacyPassword
                        ? $legacyPassword
                        : Hash::make(Str::random(64)),
                    'name' => trim((string) $record['nome']),
                    'email' => $email,
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'last_login' => $record['ultimo_acesso'] ?? null,
                    'provisoria' => $record['provisoria'] ?? null,
                    'desativado' => $record['desativado'] ?? null,
                    'created_at' => $record['criado'],
                    'updated_at' => $record['modificado'] ?? null,
                    // Primeiro inserimos todos os usuários sem as referências autorrelacionadas.
                    'creator_id' => null,
                    'updater_id' => null,
                ];
            }

            foreach (array_chunk($rows, 500) as $chunk) {
                DB::table('users')->insert($chunk);
            }

            // Segunda passagem: agora todos os IDs existem, inclusive referências a si próprio.
            foreach ($records as $record) {
                DB::table('users')
                    ->where('id', (int) $record['id'])
                    ->update([
                        'creator_id' => isset($record['criador_id']) && $record['criador_id'] !== ''
                            ? (int) $record['criador_id']
                            : null,
                        'updater_id' => isset($record['modificador_id']) && $record['modificador_id'] !== ''
                            ? (int) $record['modificador_id']
                            : null,
                    ]);
            }
        });

        $this->info(sprintf('Importação concluída: %d usuários.', count($records)));
        $this->line("Hashes legados preservados para etapa posterior de autenticação: {$legacyPasswords}.");
        $this->line("Hashes aleatórios modernos gerados para registros sem senha no dump de teste: {$generatedPasswords}.");
        $this->warn('Este comando importa dados; ele não implementa a autenticação compatível com MD5.');

        return self::SUCCESS;
    }

    /** @return array{array<int, true>, int, int} */
    private function validateRecords(array $records): array
    {
        $ids = [];
        $logins = [];
        $emails = [];
        $legacyPasswords = 0;
        $generatedPasswords = 0;

        foreach ($records as $index => $record) {
            $rowNumber = $index + 1;

            foreach (['id', 'login', 'nome', 'criado'] as $required) {
                if (! array_key_exists($required, $record) || $record[$required] === null || $record[$required] === '') {
                    throw new RuntimeException("Registro {$rowNumber}: campo obrigatório ausente ou vazio: {$required}.");
                }
            }

            if (! is_numeric($record['id']) || (int) $record['id'] < 1) {
                throw new RuntimeException("Registro {$rowNumber}: ID inválido.");
            }

            $id = (int) $record['id'];
            if (isset($ids[$id])) {
                throw new RuntimeException("ID duplicado no arquivo de importação: {$id}.");
            }
            $ids[$id] = true;

            $loginKey = mb_strtolower(trim((string) $record['login']));
            if ($loginKey === '') {
                throw new RuntimeException("Registro {$rowNumber}: login vazio.");
            }
            if (isset($logins[$loginKey])) {
                throw new RuntimeException("Login duplicado no arquivo de importação: {$record['login']}.");
            }
            $logins[$loginKey] = true;

            $email = $record['email'] ?? null;
            $email = $email === null ? '' : trim((string) $email);
            if ($email !== '') {
                $emailKey = mb_strtolower($email);
                if (isset($emails[$emailKey])) {
                    throw new RuntimeException("E-mail duplicado no arquivo de importação: {$email}.");
                }
                $emails[$emailKey] = true;
            }

            $password = $record['senha'] ?? null;
            if (is_string($password) && trim($password) !== '') {
                $legacyPasswords++;
            } else {
                $generatedPasswords++;
            }
        }

        // Cada referência precisa apontar para um usuário que será importado neste mesmo conjunto.
        foreach ($records as $index => $record) {
            foreach (['criador_id', 'modificador_id'] as $field) {
                $reference = $record[$field] ?? null;
                if ($reference === null || $reference === '') {
                    continue;
                }
                if (! isset($ids[(int) $reference])) {
                    throw new RuntimeException(sprintf(
                        'Registro %d: %s aponta para o ID %s, que não está no arquivo. Importe o conjunto completo de usuários relacionados.',
                        $index + 1,
                        $field,
                        (string) $reference
                    ));
                }
            }
        }

        return [$ids, $legacyPasswords, $generatedPasswords];
    }
}
