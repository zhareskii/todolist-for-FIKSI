<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class)->middleware('auth');
Route::get('/todolist2', [AuthController::class, 'tampilLogin'])->name('layout.index');

// Authentication
Route::get('/regis', [AuthController::class, 'showRegis'])->name('regis.tampil');
Route::post('/regis/submit', [AuthController::class, 'submitRegis'])->name('regis.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.tampil');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');

// Tasks (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [TaskController::class, 'showHome'])->name('layout.home');
    Route::resource('tasks', TaskController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks/list', [TaskController::class, 'list'])->name('tasks.list');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
});
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
