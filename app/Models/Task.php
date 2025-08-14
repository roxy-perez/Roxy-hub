<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assignee_id',
        'due_date',
        'comments',
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'todo' => 'bg-gray-500 text-white',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'blocked' => 'bg-red-600 text-white',
            'done' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'todo' => 'Pendiente',
            'in_progress' => 'En progreso',
            'blocked' => 'Bloqueado',
            'done' => 'Completado',
            default => 'Pendiente'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            1 => 'bg-red-600 text-white',
            2 => 'bg-amber-200 text-amber-800',
            3 => 'bg-yellow-100 text-yellow-800',
            4 => 'bg-green-100 text-green-800',
            5 => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            1 => 'Crítico',
            2 => 'Alto',
            3 => 'Medio',
            4 => 'Bajo',
            5 => 'Muy bajo',
            default => 'Medio'
        };
    }
}
