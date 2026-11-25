<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users with search and status filters.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:ativos,desativados,todos'],
            'perfil' => ['nullable', 'in:todos,admin,comum'],
        ]);

        $search = trim($filters['search'] ?? '');
        $status = $filters['status'] ?? 'ativos';
        $perfil = $filters['perfil'] ?? 'todos';

        $users = User::query()
            ->select([
                'id',
                'name',
                'login',
                'email',
                'is_admin',
                'provisoria',
                'desativado',
                'last_login',
                'created_at',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('login', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status === 'ativos', function ($query) {
                $query->where(function ($query) {
                    $query->where('desativado', false)
                        ->orWhereNull('desativado');
                });
            })
            ->when($status === 'desativados', function ($query) {
                $query->where('desativado', true);
            })
            ->when($perfil === 'admin', function ($query) {
                $query->where('is_admin', true);
            })
            ->when($perfil === 'comum', function ($query) {
                $query->where('is_admin', false);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', compact('users', 'search', 'status', 'perfil'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:20', 'unique:users,login'],
            'email' => ['nullable', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ], [
            'name.required' => 'Preencha o nome do usuário.',
            'login.required' => 'Preencha o login.',
            'login.max' => 'O login deve ter no máximo 20 caracteres.',
            'login.unique' => 'Este login já está em uso.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'Preencha a senha.',
            'password.min' => 'A senha deve ter pelo menos 4 caracteres.',
            'password.confirmed' => 'As senhas informadas não conferem.',
        ]);

        User::create([
            'name' => trim($validated['name']),
            'login' => trim($validated['login']),
            'email' => filled($validated['email'] ?? null) ? trim($validated['email']) : null,
            'password' => $validated['password'],
            'is_admin' => $request->boolean('is_admin'),
            'provisoria' => $request->boolean('provisoria'),
            'desativado' => false,
            'creator_id' => Auth::id(),
        ]);

        return redirect()
            ->route('users.index')
            ->with('status', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'login')->ignore($user->id),
            ],
            'email' => ['nullable', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:4', 'confirmed'],
        ], [
            'name.required' => 'Preencha o nome do usuário.',
            'login.required' => 'Preencha o login.',
            'login.max' => 'O login deve ter no máximo 20 caracteres.',
            'login.unique' => 'Este login já está em uso.',
            'email.email' => 'Informe um e-mail válido.',
            'password.min' => 'A senha deve ter pelo menos 4 caracteres.',
            'password.confirmed' => 'As senhas informadas não conferem.',
        ]);

        $isSelf = Auth::id() === $user->id;
        $isAdmin = $isSelf ? true : $request->boolean('is_admin');
        $desativado = $isSelf ? false : $request->boolean('desativado');

        $data = [
            'name' => trim($validated['name']),
            'login' => trim($validated['login']),
            'email' => filled($validated['email'] ?? null) ? trim($validated['email']) : null,
            'is_admin' => $isAdmin,
            'provisoria' => $request->boolean('provisoria'),
            'desativado' => $desativado,
            'updater_id' => Auth::id(),
        ];

        if (filled($validated['password'] ?? null)) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('status', 'Usuário atualizado com sucesso.');
    }

    /**
     * Toggle active/inactive status of the specified user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->withErrors(['user' => 'Você não pode desativar o seu próprio usuário.']);
        }

        $novoStatus = ! $user->desativado;

        $user->update([
            'desativado' => $novoStatus,
            'updater_id' => Auth::id(),
        ]);

        $mensagem = $novoStatus
            ? 'Usuário desativado com sucesso.'
            : 'Usuário reativado com sucesso.';

        return redirect()
            ->route('users.index')
            ->with('status', $mensagem);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->withErrors(['user' => 'Você não pode excluir o seu próprio usuário.']);
        }

        try {
            $user->delete();
        } catch (QueryException) {
            return redirect()
                ->route('users.index')
                ->withErrors(['user' => 'Não foi possível excluir este usuário pois existem registros vinculados a ele. Considere desativá-lo.']);
        }

        return redirect()
            ->route('users.index')
            ->with('status', 'Usuário excluído com sucesso.');
    }
}
