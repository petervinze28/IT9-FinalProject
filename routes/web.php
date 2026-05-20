<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CleaningTaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HousekeeperController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('auth.login');
});

Route::middleware('guest')->group(function () {
	Route::get('/login', [AuthController::class, 'create'])->name('login');
	Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
	Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

	Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
	Route::post('/rooms/{room}/status', [RoomController::class, 'updateStatus'])->name('rooms.update-status');

	Route::middleware('admin')->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
		Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
		Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
		Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
		Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

		Route::resource('housekeepers', HousekeeperController::class)->except(['show', 'create']);
		Route::resource('tasks', CleaningTaskController::class)->except(['show', 'create']);
	});
});
