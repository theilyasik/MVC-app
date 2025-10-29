<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CosmetologistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ServiceController;

// 1→M
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);

Route::get('/cosmetologists', [CosmetologistController::class, 'index']);
Route::get('/cosmetologists/{id}', [CosmetologistController::class, 'show']);

// M→M
Route::get('/sessions/{id}', [SessionController::class, 'show']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
