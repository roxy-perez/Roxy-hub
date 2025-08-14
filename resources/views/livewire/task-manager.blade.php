<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-serif dark:text-white">Gestión de tareas</h1>
                <p class="mt-2 text-sm text-gray-600 font-sans dark:text-gray-400 ">Administra y rastrea tus tareas de
                    proyecto de manera
                    eficiente.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button wire:click="backToProjects"
                    class="inline-flex items-center p-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-cyan-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-skip-backward-fill" viewBox="0 0 16 16">
                        <path
                            d="M.5 3.5A.5.5 0 0 0 0 4v8a.5.5 0 0 0 1 0V8.753l6.267 3.636c.54.313 1.233-.066 1.233-.697v-2.94l6.267 3.636c.54.314 1.233-.065 1.233-.696V4.308c0-.63-.693-1.01-1.233-.696L8.5 7.248v-2.94c0-.63-.692-1.01-1.233-.696L1 7.248V4a.5.5 0 0 0-.5-.5" />
                    </svg>
                    <span class="font-mono">&nbsp;Ir a Proyectos</span>
                </button>
                <button wire:click="openCreateForm"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs font-mono text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Crear Tarea
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-800 dark:text-green-200"
            role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Filters and Search -->
    <div class="bg-gray-100 rounded-lg shadow-sm border border-gray-200 p-6 mb-6 dark:bg-gray-800 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label for="search"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar</label>
                <input wire:model.live="search" type="text" id="search"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-100 placeholder-gray-400"
                    placeholder="Buscar tareas...">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="filterStatus"
                    class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Estados</label>
                <select wire:model.live="filterStatus" id="filterStatus"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Todos los estados</option>
                    <option value="todo">Pendiente</option>
                    <option value="in_progress">En curso</option>
                    <option value="blocked">Bloqueado</option>
                    <option value="done">Hecho</option>
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label for="filterPriority"
                    class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Prioridad</label>
                <select wire:model.live="filterPriority" id="filterPriority"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Todas las prioridades</option>
                    <option value="1">Crítico</option>
                    <option value="2">Alta</option>
                    <option value="3">Media</option>
                    <option value="4">Baja</option>
                    <option value="5">Muy baja</option>
                </select>
            </div>

            <!-- Project Filter -->
            <div>
                <label for="filterProject"
                    class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Proyectos</label>
                <select wire:model.live="filterProject" id="filterProject"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Todos los proyectos</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Assignee Filter -->
            <div>
                <label for="filterAssignee"
                    class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Asignados</label>
                <select wire:model.live="filterAssignee" id="filterAssignee"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Todos los asignados</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Clear Filters -->
        <div class="mt-4 flex justify-end">
            <button wire:click="clearFilters"
                class="text-sm text-gray-600 hover:text-gray-900 underline dark:text-gray-300 dark:hover:text-white">
                Limpiar filtros
            </button>
        </div>
    </div>

    <!-- Tasks Table -->
    <div
        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden dark:bg-gray-900 dark:border-gray-700">
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th wire:click="sortBy('title')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="flex items-center space-x-1">
                                <span>Tarea</span>
                                @if ($sortBy === 'title')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Proyecto
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Estado
                        </th>
                        <th wire:click="sortBy('priority')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="flex items-center space-x-1">
                                <span>Prioridad</span>
                                @if ($sortBy === 'priority')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Asignado
                        </th>
                        <th wire:click="sortBy('due_date')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="flex items-center space-x-1">
                                <span>Fecha límite</span>
                                @if ($sortBy === 'due_date')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-pink-50 dark:hover:bg-pink-900/20">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $task->title }}</div>
                                    @if ($task->description)
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ Str::limit($task->description, 60) }}</div>
                                    @endif
                                    @if ($task->comments)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <span
                                                class="font-semibold text-gray-700 dark:text-gray-300">Comentarios:</span>
                                            {{ Str::limit($task->comments, 80) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-sm text-gray-900 dark:text-gray-100">{{ $task->project->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $task->status_color }}">
                                        {{ $task->status_label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $task->priority_color }}">
                                    {{ $task->priority_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($task->assignee)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                                                    {{ substr($task->assignee->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $task->assignee->name }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span
                                        class="text-xs rounded-full p-2 bg-gray-200 dark:bg-gray-700 font-bold text-gray-500 dark:text-gray-300">Sin
                                        asignar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if ($task->due_date)
                                    <div class="flex items-center">
                                        @if ($task->due_date->isPast() && $task->status !== 'done')
                                            <svg class="w-4 h-4 text-red-500 mr-1" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                        <span
                                            class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-600' : '' }}">
                                            {{ $task->due_date->format('d/m/Y') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Sin fecha</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="editTask({{ $task->id }})"
                                        class="text-cyan-700 hover:text-cyan-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteTask({{ $task->id }})"
                                        wire:confirm="¿Seguro que desea eliminar la tarea {{ $task->title }}?"
                                        class="text-red-600 hover:text-red-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay tareas
                                        encontradas</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Comienza creando tu primera tarea.
                                    </p>
                                    <button wire:click="backToProjects"
                                        class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700">
                                        Volver a proyectos
                                    </button>
                                    <button wire:click="openCreateForm"
                                        class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700">
                                        Crear Tarea
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden">
            @forelse($tasks as $task)
                <div class="border-b border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                    {{ $task->title }}
                                </h3>
                                <div class="flex items-center space-x-2 ml-2">
                                    <button wire:click="editTask({{ $task->id }})"
                                        class="text-pink-600 hover:text-pink-900 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteTask({{ $task->id }})"
                                        wire:confirm="¿Seguro que desea eliminar la tarea {{ $task->title }}?"
                                        class="text-red-600 hover:text-red-900 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @if ($task->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    {{ Str::limit($task->description, 100) }}
                                </p>
                            @endif
                            @if ($task->comments)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Comentarios:</span>
                                    {{ Str::limit($task->comments, 120) }}
                                </p>
                            @endif

                            <div class="flex flex-wrap gap-2 mb-3">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $task->status_color }}">
                                    {{ $task->status_label }}
                                </span>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $task->priority_color }}">
                                    {{ $task->priority_label }}
                                </span>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span class="truncate">{{ $task->project->name }}</span>
                                </div>

                                @if ($task->assignee)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="truncate">{{ $task->assignee->name }}</span>
                                    </div>
                                @endif

                                @if ($task->due_date)
                                    <div
                                        class="flex items-center {{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-600' : 'text-gray-600 dark:text-gray-400' }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ $task->due_date->format('d/m/Y') }}</span>
                                        @if ($task->due_date->isPast() && $task->status !== 'done')
                                            <span class="ml-1 text-xs">(Vencida)</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No tareas encontradas
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Comienza creando tu primera tarea.</p>
                        <button wire:click="backToProjects"
                            class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700">
                            Volver a proyectos
                        </button>
                        <button wire:click="openCreateForm"
                            class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700">
                            Crear Tarea
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($tasks->hasPages())
            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>

    <!-- Create Task Modal -->
    @if ($showCreateForm)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeCreateForm">
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="createTask">
                        <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Crear Tarea</h3>

                                <!-- Title -->
                                <div class="mb-4">
                                    <label for="title"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Nombre
                                        *</label>
                                    <input wire:model="title" type="text" id="title"
                                        class="w-full rounded-md text-gray-800 border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Nombre de la tarea" autofocus>
                                    @error('title')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Descripción</label>
                                    <textarea wire:model="description" id="description" rows="3"
                                        class="w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Describe la tarea"></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Comments -->
                                <div class="mb-4">
                                    <label for="comments"
                                        class="block text-sm font-medium text-gray-600 dark:text-gray-100 mb-1">Comentarios</label>
                                    <textarea wire:model="comments" id="comments" rows="3"
                                        class="w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Anota ideas, notas o cosas que podrías hacer durante esta tarea"></textarea>
                                    @error('comments')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Project -->
                                <div class="mb-4">
                                    <label for="project_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Proyecto
                                        *</label>
                                    <select wire:model="project_id" id="project_id"
                                        class="w-full rounded-md border-gray-300 shadow-sm text-gray-700 focus:border-pink-500 focus:ring-pink-500">
                                        <option value="">Selecciona un proyecto</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Status -->
                                    <div>
                                        <label for="status"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Estado</label>
                                        <select wire:model="status" id="status"
                                            class="w-full rounded-md border-gray-300 text-gray-600 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                            <option value="todo">To Do</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="blocked">Blocked</option>
                                            <option value="done">Done</option>
                                        </select>
                                        @error('status')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Priority -->
                                    <div>
                                        <label for="priority"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Prioridad</label>
                                        <select wire:model="priority" id="priority"
                                            class="w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                            <option value="1">Crítica</option>
                                            <option value="2">Alta</option>
                                            <option value="3">Media</option>
                                            <option value="4">Baja</option>
                                            <option value="5">Muy Baja</option>
                                        </select>
                                        @error('priority')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Assignee -->
                                    <div>
                                        <label for="assignee_id"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100  mb-1">Asignado</label>
                                        <select wire:model="assignee_id" id="assignee_id"
                                            class="w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                            <option value="">No asignado</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assignee_id')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Due Date -->
                                    <div>
                                        <label for="due_date"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Fecha
                                            Límite</label>
                                        <input wire:model="due_date" type="date" id="due_date"
                                            class="w-full rounded-md border-gray-300 shadow-sm text-gray-700 focus:border-pink-500 focus:ring-pink-500">
                                        @error('due_date')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Guardar
                            </button>
                            <button type="button" wire:click="closeCreateForm"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-500 text-base font-medium text-white hover:bg-cyan-200 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Task Modal -->
    @if ($showEditForm)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="hideEditForm">
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-gray-50 dark:bg-gray-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="updateTask">
                        <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Editar Tarea</h3>

                                <!-- Title -->
                                <div class="mb-4">
                                    <label for="edit_title"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Nombre
                                        *</label>
                                    <input wire:model="title" type="text" id="edit_title"
                                        class="w-full rounded-md text-gray-700 border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Nombre de la tarea">
                                    @error('title')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="edit_description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Descripción</label>
                                    <textarea wire:model="description" id="edit_description" rows="3"
                                        class="w-full text-gray-700 rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Describe la tarea"></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Comments -->
                                <div class="mb-4">
                                    <label for="edit_comments"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Comentarios</label>
                                    <textarea wire:model="comments" id="edit_comments" rows="3"
                                        class="w-full rounded-md border-gray-300 dark:text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Anota ideas, notas o cosas que podrías hacer durante esta tarea"></textarea>
                                    @error('comments')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Project -->
                                <div class="mb-4">
                                    <label for="edit_project_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Proyecto
                                        *</label>
                                    <select wire:model="project_id" id="edit_project_id"
                                        class="w-full rounded-md border-gray-300 dark:text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                        <option value="">Asignar proyecto</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Status -->
                                    <div>
                                        <label for="edit_status"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Estado</label>
                                        <select wire:model="status" id="edit_status"
                                            class="w-full rounded-md border-gray-300 text-gray-800 dark:text-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                            <option value="todo">Pendiente</option>
                                            <option value="in_progress">En progreso</option>
                                            <option value="blocked">Bloqueado</option>
                                            <option value="done">Completado</option>
                                        </select>
                                        @error('status')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Priority -->
                                    <div>
                                        <label for="edit_priority"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Prioridad</label>
                                        <select wire:model="priority" id="edit_priority"
                                            class="w-full rounded-md border-gray-300 text-gray-800 shadow-sm dark:text-gray-700 focus:border-pink-500 focus:ring-pink-500">
                                            <option value="1">Crítico</option>
                                            <option value="2">Alta</option>
                                            <option value="3">Media</option>
                                            <option value="4">Baja</option>
                                            <option value="5">Muy baja</option>
                                        </select>
                                        @error('priority')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Assignee -->
                                    <div>
                                        <label for="edit_assignee_id"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Asignado
                                            a</label>
                                        <select wire:model="assignee_id" id="edit_assignee_id"
                                            class="w-full rounded-md border-gray-300 text-gray-800 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                            <option value="">No asignado</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assignee_id')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Due Date -->
                                    <div>
                                        <label for="edit_due_date"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Fecha
                                            límite</label>
                                        <input wire:model="due_date" type="date" id="edit_due_date"
                                            class="w-full rounded-md border-gray-300 text-gray-800 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                        @error('due_date')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Actualizar
                            </button>
                            <button type="button" wire:click="hideEditForm"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-500 text-base font-medium text-gray-50 hover:bg-cyan-200 hover:text-gray-800 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
