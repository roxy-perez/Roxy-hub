<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert as LivewireAlertTrait;

class TaskManager extends Component
{
    use WithPagination;
    use LivewireAlertTrait;

    // Task form properties
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('required|exists:projects,id')]
    public $project_id = '';

    #[Validate('required|in:todo,in_progress,blocked,done')]
    public $status = 'todo';

    #[Validate('required|integer|min:1|max:5')]
    public $priority = 3;

    #[Validate('nullable|exists:users,id')]
    public $assignee_id = '';

    #[Validate('nullable|date')]
    public $due_date = '';

    #[Validate('nullable|string')]
    public $comments = '';

    // UI state
    public $showCreateForm = false;
    public $showEditForm = false;
    public $editingTaskId = null;

    // Filters
    public $filterStatus = '';
    public $filterPriority = '';
    public $filterProject = '';
    public $filterAssignee = '';
    public $search = '';

    // Sorting
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'filterProject' => ['except' => ''],
        'filterAssignee' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        $projects = Project::all();
        if ($projects->count() === 1) {
            $this->project_id = $projects->first()->id;
        }
    }

    public function render()
    {
        $tasks = $this->getTasks();
        $projects = Project::all();
        $users = User::all();

        return view('livewire.task-manager', [
            'tasks' => $tasks,
            'projects' => $projects,
            'users' => $users,
        ]);
    }

    public function getTasks()
    {
        $query = Task::with(['project', 'assignee']);

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'ilike', '%' . $this->search . '%')
                    ->orWhere('description', 'ilike', '%' . $this->search . '%');
            });
        }

        // Apply filters
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        if ($this->filterProject) {
            $query->where('project_id', $this->filterProject);
        }

        if ($this->filterAssignee) {
            $query->where('assignee_id', $this->filterAssignee);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(10);
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['filterStatus', 'filterPriority', 'filterProject', 'filterAssignee', 'search']);
    }

    public function backToProjects(): void
    {
        $this->redirect('/projects');
    }
    public function openCreateForm(): void
    {
        $this->showCreateForm = true;
        $this->resetForm();
    }

    public function closeCreateForm(): void
    {
        $this->showCreateForm = false;
        $this->resetForm();
    }

    public function createTask(): void
    {
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->project_id,
            'status' => $this->status,
            'priority' => $this->priority,
            'assignee_id' => $this->assignee_id ?: null,
            'due_date' => $this->due_date ?: null,
            'comments' => $this->comments ?: null,
        ]);

        $this->closeCreateForm();
        $this->alert('success', '¡Tarea creada!', [
            'text' => 'Tarea creada correctamente.',
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    public function editTask($taskId): void
    {
        $task = Task::findOrFail($taskId);

        $this->editingTaskId = $taskId;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->project_id = $task->project_id;
        $this->status = $task->status;
        $this->priority = $task->priority;
        $this->assignee_id = $task->assignee_id;
        $this->due_date = $task->due_date?->format('Y-m-d');
        $this->comments = $task->comments;

        $this->showEditForm = true;
    }

    public function updateTask(): void
    {
        $this->validate();

        $task = Task::findOrFail($this->editingTaskId);
        $task->update([
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->project_id,
            'status' => $this->status,
            'priority' => $this->priority,
            'assignee_id' => $this->assignee_id ?: null,
            'due_date' => $this->due_date ?: null,
            'comments' => $this->comments ?: null,
        ]);

        $this->hideEditForm();
        $this->alert('success', '¡Tarea actualizada!', [
            'text' => 'Tarea actualizada correctamente.',
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    public function hideEditForm(): void
    {
        $this->showEditForm = false;
        $this->resetForm();
        $this->editingTaskId = null;
    }

    public function deleteTask($taskId): void
    {
        Task::findOrFail($taskId)->delete();
        $this->alert('');
        $this->alert('success', '¡Tarea eliminada!', [
            'text' => 'Tarea eleminada correctamente.',
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    public function updateTaskStatus($taskId, $status): void
    {
        $task = Task::findOrFail($taskId);
        $task->update(['status' => $status]);
        $this->alert('success', '¡Estado actualizado!', [
            'text' => 'Estado de la tarea actualizado correctamente.',
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['title', 'description', 'status', 'priority', 'assignee_id', 'due_date', 'comments']);
        $this->status = 'todo';
        $this->priority = 3;

        // Keep project_id if only one project exists
        $projects = Project::all();
        if ($projects->count() !== 1) {
            $this->project_id = '';
        }
    }
}
