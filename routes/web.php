<?php

use App\Livewire\ProjectManager;
use App\Livewire\TaskManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('profile', 'profile')
        ->name('profile');

    Route::get('/projects', ProjectManager::class)
        ->name('projects');

    Route::get('/tasks', TaskManager::class)
        ->name('tasks');

    Route::get('/projects/{project}/tasks', function (\App\Models\Project $project) {
        return redirect()->route('tasks', ['filterProject' => $project->id]);
    })->name('projects.tasks.index');
});

require __DIR__ . '/auth.php';
