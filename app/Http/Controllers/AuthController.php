<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the home screen or login screen depending on authentication status.
     */
    public function home(): View
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Show the login form for guest users.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'usuario_login' => ['required', 'string'],
            'usuario_senha' => ['required', 'string'],
        ], [
            'usuario_login.required' => 'Preencha o login',
            'usuario_senha.required' => 'Preencha a senha',
        ]);

        $loginInput = $credentials['usuario_login'];
        $password = $credentials['usuario_senha'];
        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'login' => $loginInput,
            'password' => $password,
        ], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'usuario_login' => 'Login e/ou senha inválido(s)',
        ])->onlyInput('usuario_login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Você saiu do sistema');
    }

    /**
     * Show the password change form for authenticated users.
     */
    public function showPasswordChangeForm(): View
    {
        return view('auth.password_change');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'senha_atual' => ['required', 'string'],
            'nova_senha' => ['required', 'string', 'min:4'],
            'repita_senha' => ['required', 'string', 'same:nova_senha'],
        ], [
            'senha_atual.required' => 'Preencha a senha atual',
            'nova_senha.required' => 'Preencha a nova senha',
            'repita_senha.required' => 'Repita a nova senha',
            'repita_senha.same' => 'Repita a nova senha',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (! Hash::check($request->input('senha_atual'), $user->password)) {
            return back()->withErrors([
                'senha_atual' => 'A senha atual informada está incorreta.',
            ])->onlyInput('senha_atual');
        }

        $user->password = Hash::make($request->input('nova_senha'));
        $user->save();

        return redirect()->route('password.change')->with('status', 'Senha trocada com sucesso');
    }
}
