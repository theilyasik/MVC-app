<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CosmetologistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LoginController;

// Главная
Route::view('/', 'home');

// Публичные разделы
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);

Route::get('/cosmetologists', [CosmetologistController::class, 'index']);
Route::get('/cosmetologists/{id}', [CosmetologistController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');

// Сеансы: публично видны список и просмотр
Route::resource('sessions', SessionController::class)->only(['index','show']);

// Сеансы: создание/редактирование/удаление — только для вошедших
Route::middleware('auth')->group(function () {
    Route::resource('sessions', SessionController::class)->only([
        'create','store','edit','update','destroy'
    ]);
});

// Логин/логаут
Route::get('/login',  [LoginController::class, 'login'])->name('login');
Route::post('/auth',  [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Экран ошибки (читает флэш-сообщение)
Route::get('/error', function () {
    return view('error', ['message' => session('message')]);
})->name('error');
