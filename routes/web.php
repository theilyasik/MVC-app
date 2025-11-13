<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CosmetologistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LoginController;

// Главная
Route::view('/', 'home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware('auth')->group(function () {

    Route::patch('sessions/{session}/status', [SessionController::class, 'updateStatus'])
        ->name('sessions.update-status');
        
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    Route::get('/cosmetologists', [CosmetologistController::class, 'index'])->name('cosmetologists.index');
    Route::get('/cosmetologists/{id}', [CosmetologistController::class, 'show'])->name('cosmetologists.show');
    Route::post('/cosmetologists', [CosmetologistController::class, 'store'])->name('cosmetologists.store');

    Route::resource('sessions', SessionController::class)
        ->whereNumber('session');
});

// Логин/логаут
Route::get('/login',  [LoginController::class, 'login'])->name('login');
Route::post('/auth',  [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Экран ошибки (читает флэш-сообщение)
Route::get('/error', function () {
    return view('error', ['message' => session('message')]);
})->name('error');