<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas de Login
Route::middleware('auth')->group(function () {
    Route::get('/trocar-senha', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');
    Route::post('/trocar-senha', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::get('/trocarsenha', fn () => redirect()->route('password.change'));
});
