<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SportsGamesTypeController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\BetsController;
use App\Http\Controllers\AccountsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/store', [AuthController::class, 'store'])->name('store');


Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'index'])->name('index');
        Route::get('create', [RolePermissionController::class, 'create'])->name('create');
        Route::post('create', [RolePermissionController::class, 'store']);
        Route::get('{role}/edit', [RolePermissionController::class, 'edit'])->name('edit');
        Route::post('{role}/edit', [RolePermissionController::class, 'update']);
        Route::get('show/{role}', [RolePermissionController::class, 'show'])->name('show');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('create', [UserController::class, 'store']);
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('{user}/edit', [UserController::class, 'update']);
        Route::get('{user}/show', [UserController::class, 'show'])->name('show');
        Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('{user}/restore', [UserController::class, 'restore'])->name('restore');
    });

    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/', [GameController::class, 'index'])->name('index');
        Route::get('create', [GameController::class, 'create'])->name('create');
        Route::post('create', [GameController::class, 'store']);
        Route::get('{game}/edit', [GameController::class, 'edit'])->name('edit');
        Route::post('{game}/edit', [GameController::class, 'update']);
        Route::get('{game}/show', [GameController::class, 'show'])->name('show');
        Route::delete('{game}/delete', [GameController::class, 'destroy'])->name('destroy');
        Route::patch('{game}/restore', [GameController::class, 'restore'])->name('restore');
    });

    Route::prefix('gametypes')->name('gametypes.')->group(function () {
        Route::get('/', [SportsGamesTypeController::class, 'index'])->name('index');
        Route::get('create', [SportsGamesTypeController::class, 'create'])->name('create');
        Route::post('create', [SportsGamesTypeController::class, 'store']);
        Route::get('{gametype}/edit', [SportsGamesTypeController::class, 'edit'])->name('edit');
        Route::post('{gametype}/edit', [SportsGamesTypeController::class, 'update']);
        Route::get('{gametype}/show', [SportsGamesTypeController::class, 'show'])->name('show');
        Route::delete('{gametype}/delete', [SportsGamesTypeController::class, 'destroy'])->name('destroy');
        Route::patch('{gametype}/restore', [SportsGamesTypeController::class, 'restore'])->name('restore');
    });

    Route::prefix('bets')->name('bets.')->group(function () {
        Route::get('/', [BetsController::class, 'index'])->name('index');
        Route::get('create', [BetsController::class, 'create'])->name('create');
        Route::post('create', [BetsController::class, 'store']);
        // Route::get('{bet}/edit', [BetsController::class, 'edit'])->name('edit');
        // Route::post('{bet}/edit', [BetsController::class, 'update']);
        Route::get('{bet}/show', [BetsController::class, 'show'])->name('show');
        Route::delete('{bet}/delete', [BetsController::class, 'destroy'])->name('destroy');
        Route::patch('{bet}/restore', [BetsController::class, 'restore'])->name('restore');
    });

    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/', [AccountsController::class, 'index'])->name('index');
    });

    // Our resource routes
    Route::resource('roles', RolePermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('games', GameController::class);
    Route::resource('gametypes', SportsGamesTypeController::class);
    Route::resource('bets', BetsController::class);
    Route::resource('accounts', AccountsController::class);
});

Route::get('console', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

require __DIR__.'/auth.php';
