<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieCatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieCatalogController::class, 'index'])->name('movies.index');
Route::get('/filmes/{movie}', [MovieCatalogController::class, 'show'])->name('movies.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('movies', MovieController::class)->except(['show']);
    });
