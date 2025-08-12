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
});

Route::middleware('auth')->group(function () {
    Route::get('/projects', ProjectManager::class)
        ->name('projects');
    Route::get('/projects/{project}/tasks', function (\App\Models\Project $project) {
        return redirect()->route('tasks', ['project' => $project->id]);
    })->name('projects.tasks.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/tasks', TaskManager::class)
        ->name('tasks');
});

require __DIR__ . '/auth.php';
