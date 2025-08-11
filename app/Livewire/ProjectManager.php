<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert as LivewireAlertTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectManager extends Component
{
    use LivewireAlertTrait;
    public $name;
    public $description;
    public $visibility = 'public';
    public $projects;
    public $editingId = null;


    protected $listeners = ['confirmDelete'];

    public function mount()
    {
        $this->projects = Project::where('owner_id', Auth::id())->get();
    }
    public function createProject()
    {
        if (!Auth::check()) {
            $this->alert('error', 'Acceso denegado', [
                'text' => 'Debes iniciar sesión para crear un proyecto.',
                'toast' => true,
                'position' => 'top-end',
            ]);
            return;
        }
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:public,private,team',
        ]);
        $p = Project::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . Str::random(6),
            'owner_id' => Auth::id(),
            'description' => $this->description,
            'visibility' => $this->visibility,
        ]);
        $this->projects->push($p);
        $this->name = '';
        $this->description = '';
        $this->visibility = 'public';
        $this->alert('success', '¡Proyecto creado!', [
            'text' => 'El proyecto se creó correctamente.',
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    public function startEdit(int $id): void
    {
        $project = Project::where('id', $id)->where('owner_id', Auth::id())->first();
        if (!$project) {
            $this->alert('error', 'Proyecto no encontrado', [
                'text' => 'No existe o no tienes permiso.',
                'position' => 'top-end',
            ]);
            return;
        }
        $this->editingId = $project->id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->visibility = $project->visibility;
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    public function save(): void
    {
        if ($this->editingId) {
            $this->updateProject();
        } else {
            $this->createProject();
        }
    }

    protected function updateProject(): void
    {
        if (!Auth::check()) {
            $this->alert('error', 'Acceso denegado', [
                'text' => 'Debes iniciar sesión para editar.',
                'position' => 'top-end',
            ]);
            return;
        }
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:public,private,team',
        ]);

        $project = Project::where('id', $this->editingId)
            ->where('owner_id', Auth::id())
            ->first();

        if (!$project) {
            $this->alert('error', 'No se pudo actualizar', [
                'text' => 'El proyecto no existe o no tienes permiso.',
                'position' => 'top-end',
            ]);
            return;
        }

        $project->update([
            'name' => $this->name,
            'description' => $this->description,
            'visibility' => $this->visibility,
        ]);

        $this->projects = $this->projects->map(function ($p) use ($project) {
            if ($p->id === $project->id) {
                $p->name = $project->name;
                $p->description = $project->description;
                $p->visibility = $project->visibility;
            }
            return $p;
        });

        $this->alert('success', 'Proyecto actualizado', [
            'position' => 'top-end',
            'toast' => true,
        ]);

        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->description = '';
        $this->visibility = 'public';
    }


    public function preDelete($id): void
    {
        $this->alert('warning', '¿Estás segura de eliminar este proyecto?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí, eliminar',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'onConfirmed' => 'confirmDelete',
            'data' => ['id' => $id],
            'toast' => false,
            'position' => 'center',
        ]);
    }

    public function confirmDelete($data): void
    {
        $id = data_get($data, 'data.id', data_get($data, 'id'));
        if ($id) {
            $this->deleteProject($id);
        }
    }

    public function deleteProject($id): void
    {
        $project = Project::where('id', $id)->where('owner_id', Auth::id())->first();
        if ($project) {
            $project->delete();
            $this->projects = $this->projects->filter(fn($p) => $p->id !== $id)->values();
            $this->alert('success', 'Proyecto eliminado correctamente.', [
                'position' => 'top-end'
            ]);
        } else {
            $this->alert('error', 'No se pudo eliminar el proyecto.', [
                'position' => 'top-end',
                'text' => 'El proyecto no existe o no tienes permiso para eliminarlo.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.project-manager', [
            'projects' => $this->projects
        ]);
    }
}
