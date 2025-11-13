<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CosmetologistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionStatusController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LoginController;

// Главная
Route::view('/', 'home');

// Публичные разделы
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');

Route::get('/cosmetologists', [CosmetologistController::class, 'index'])->name('cosmetologists.index');
Route::get('/cosmetologists/{id}', [CosmetologistController::class, 'show'])->name('cosmetologists.show');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');

// Сеансы: публично видны список и просмотр
Route::resource('sessions', SessionController::class)
    ->only(['index', 'show'])
    ->whereNumber('session');

// Сеансы: создание/редактирование/удаление — только для вошедших
Route::middleware('auth')->group(function () {
    Route::patch('sessions/{session}/status', SessionStatusController::class)
        ->name('sessions.update-status');

    Route::resource('sessions', SessionController::class)->only([
        'create','store','edit','update','destroy'
    ]);

    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])
        ->whereNumber('id')
        ->name('clients.destroy');

    Route::post('/cosmetologists', [CosmetologistController::class, 'store'])->name('cosmetologists.store');
    Route::delete('/cosmetologists/{id}', [CosmetologistController::class, 'destroy'])
        ->whereNumber('id')
        ->name('cosmetologists.destroy');
});

// Логин/логаут
Route::get('/login',  [LoginController::class, 'login'])->name('login');
Route::post('/auth',  [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Экран ошибки (читает флэш-сообщение)
Route::get('/error', function () {
    return view('error', ['message' => session('message')]);
})->name('error');