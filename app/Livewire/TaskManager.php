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
        // Set default project if only one exists
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
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
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

    public function clearFilters()
    {
        $this->reset(['filterStatus', 'filterPriority', 'filterProject', 'filterAssignee', 'search']);
    }

    public function showCreateForm()
    {
        $this->showCreateForm = true;
        $this->resetForm();
    }

    public function hideCreateForm()
    {
        $this->showCreateForm = false;
        $this->resetForm();
    }

    public function createTask()
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
        ]);

        $this->hideCreateForm();
        session()->flash('message', 'Task created successfully!');
    }

    public function editTask($taskId)
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

        $this->showEditForm = true;
    }

    public function updateTask()
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
        ]);

        $this->hideEditForm();
        session()->flash('message', 'Task updated successfully!');
    }

    public function hideEditForm()
    {
        $this->showEditForm = false;
        $this->resetForm();
        $this->editingTaskId = null;
    }

    public function deleteTask($taskId)
    {
        Task::findOrFail($taskId)->delete();
        $this->alert('');
        session()->flash('message', 'Task deleted successfully!');
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['status' => $status]);
        session()->flash('message', 'Task status updated!');
    }

    private function resetForm()
    {
        $this->reset(['title', 'description', 'status', 'priority', 'assignee_id', 'due_date']);
        $this->status = 'todo';
        $this->priority = 3;

        // Keep project_id if only one project exists
        $projects = Project::all();
        if ($projects->count() !== 1) {
            $this->project_id = '';
        }
    }
}
