<?php

use App\Livewire\ProjectManager;
use App\Livewire\TaskManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('profile', 'profile')
        ->name('profile');
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::get('/projects', ProjectManager::class)
        ->name('projects');
    Route::get('/tasks', TaskManager::class)
        ->name('tasks');
});

/* Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/projects', ProjectManager::class)
    ->middleware(['auth'])
    ->name('projects');

Route::get('/tasks', TaskManager::class)
    ->middleware(['auth'])
    ->name('tasks'); */

require __DIR__ . '/auth.php';
