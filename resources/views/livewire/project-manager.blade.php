<div
    class="max-w-4xl min-[1200px]:max-w-[1600px] 2xl:max-w-[1800px] mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mt-8 border border-gray-200 dark:border-gray-800">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-900 dark:text-white flex items-center gap-2 font-serif">
        <svg class="w-8 h-8 text-pink-600" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Mis Proyectos
    </h1>
    <form wire:submit.prevent="save"
          class="mb-8 flex flex-col gap-4 bg-gray-50 dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex gap-3 items-center">
            <input type="text" wire:model="name" placeholder="Nombre del proyecto"
                   class="border border-gray-300 p-2 rounded-lg flex-1 focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"/>
        </div>
        <div>
            <textarea wire:model="description" placeholder="Descripción"
                      class="border border-gray-300 p-2 rounded-lg w-full focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 resize-none min-h-[60px]"
                      rows="2"></textarea>
        </div>
        <div class="flex gap-3 items-center">
            <select wire:model="visibility"
                    class="border border-gray-300 py-2.4 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                <option value="public">Público</option>
                <option value="private">Privado</option>
                <option value="team">Equipo</option>
            </select>
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs  font-mono text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ $editingId ? 'Guardar cambios' : 'Crear' }}
                </button>
                @if ($editingId)
                    <button type="button" wire:click="cancelEdit"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 px-4 py-2 rounded-lg font-medium transition">
                        Cancelar
                    </button>
                @endif
            </div>
        </div>
    </form>
    <div
        class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Desktop Table View - Only show from 1200px -->
        <div class="hidden min-[1200px]:block min-[1200px]:max-w-none min-[1200px]:px-0 mx-auto px-4 py-6 sm:px-6 lg:px-8 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Slug
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Descripción
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Visibilidad
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Creado
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                @forelse($projects as $project)
                    <tr class="hover:bg-pink-50 dark:hover:bg-pink-900/20">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $project->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-xs text-gray-600 dark:text-gray-300 font-mono">{{ $project->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $project->description ? Str::limit($project->description, 60) : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $project->visibility === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($project->visibility === 'team' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300') }}">
                                {{ ucfirst($project->visibility) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $project->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('projects.tasks.index', $project) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                   title="Ver tareas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 6h16M4 10h16M4 14h10M4 18h10"></path>
                                    </svg>
                                </a>
                                <button type="button" wire:click="startEdit({{ $project->id }})"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" wire:click="preDelete({{ $project->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No tienes proyectos aún
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">Comienza creando tu primer
                                    proyecto.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile/Tablet Card View - Show on smaller screens -->
        <div class="min-[1200px]:hidden">
            @forelse($projects as $project)
                <div class="border-b border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <div class="space-y-3">
                        <!-- Header with name and actions -->
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 truncate">
                                    {{ $project->name }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400 font-mono mt-1">{{ $project->slug }}</p>
                            </div>
                            <div class="flex items-center space-x-2 ml-3 flex-shrink-0">
                                <button type="button" wire:click="startEdit({{ $project->id }})"
                                        class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" wire:click="preDelete({{ $project->id }})"
                                        class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($project->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $project->description }}
                            </p>
                        @endif

                        <!-- Meta information -->
                        <div class="flex flex-wrap items-center gap-3 text-sm">
                            <!-- Visibility badge -->
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $project->visibility === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($project->visibility === 'team' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300') }}">
                                {{ ucfirst($project->visibility) }}
                            </span>

                            <!-- Creation date -->
                            <div class="flex items-center text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs">{{ $project->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No tienes proyectos aún
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Comienza creando tu primer proyecto.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
