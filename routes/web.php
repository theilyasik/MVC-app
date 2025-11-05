<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CosmetologistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ServiceController;

// Главная
Route::view('/', 'home');


// 1→M
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);

Route::get('/cosmetologists', [CosmetologistController::class, 'index']);
Route::get('/cosmetologists/{id}', [CosmetologistController::class, 'show']);

// список/создание/редактирование/удаление + show
Route::resource('sessions', SessionController::class)
    ->only(['index','create','store','show','edit','update','destroy']);

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');