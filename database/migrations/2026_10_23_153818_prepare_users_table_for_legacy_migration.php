<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Identificador utilizado para autenticação
            $table->string('login', 20)->nullable();

            // Dados adicionais do legado
            $table->dateTime('last_login')->nullable();
            $table->boolean('provisoria')->nullable();
            $table->boolean('desativado')->nullable();

            // Relacionamentos de auditoria entre usuários
            $table->foreignId('creator_id')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('updater_id')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não permitir rollback que torne a coluna obrigatória
        // enquanto existirem usuários sem email
        if (DB::table('users')->whereNull('email')->exists()) {
            throw new RuntimeException(
                'Rollback bloqueado: existem usuários sem email cadastrado'
            );
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();

            $table->dropUnique('users_login_unique');

            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('updated_by');

            $table->dropColumn([
                'login',
                'last_login_at',
                'provisoria',
                'desativado',
            ]);
        });
    }
};
