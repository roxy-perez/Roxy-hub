<?php

use App\Livewire\ProjectManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/projects', ProjectManager::class)
    ->middleware(['auth'])
    ->name('projects');

require __DIR__.'/auth.php';
