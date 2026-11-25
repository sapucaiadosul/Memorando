<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas autenticadas
Route::middleware('auth')->group(function () {
    Route::get('/trocar-senha', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');
    Route::post('/trocar-senha', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::get('/trocarsenha', fn () => redirect()->route('password.change'));

    // Gerenciamento de Usuários (somente administradores)
    Route::middleware('can:manage-users')->group(function () {
        Route::resource('usuarios', UserController::class)
            ->names('users')
            ->parameters(['usuarios' => 'user'])
            ->except(['show']);
        Route::patch('usuarios/{user}/status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
    });
});
