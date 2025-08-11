<div
    class="max-w-4xl mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mt-8 border border-gray-200 dark:border-gray-800">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-900 dark:text-white flex items-center gap-2 font-serif">
        <svg class="w-8 h-8 text-pink-600" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Mis Proyectos
    </h1>
    <form wire:submit.prevent="save"
        class="mb-8 flex flex-col gap-4 bg-gray-50 dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex gap-3 items-center">
            <input type="text" wire:model="name" placeholder="Nombre del proyecto"
                class="border border-gray-300 p-2 rounded-lg flex-1 focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" />
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
    <div class="overflow-x-auto rounded-xl shadow">
        <table class="min-w-full bg-white dark:bg-gray-900 rounded-xl font-sans">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-left">Nombre
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-left">Slug
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-left">
                        Descripción
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-left">
                        Visibilidad
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-left">Creado
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-left">Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr class="hover:bg-pink-100 dark:hover:bg-gray-800 transition duration-200">
                        <td
                            class="py-3 px-4 border-b border-gray-100 dark:border-gray-800 font-medium text-gray-900 dark:text-gray-100">
                            {{ $project->name }}</td>
                        <td
                            class="py-3 px-4 border-b border-gray-100 dark:border-gray-800 text-xs text-gray-600 dark:text-gray-300">
                            {{ $project->slug }}</td>
                        <td
                            class="py-3 px-4 border-b border-gray-100 dark:border-gray-800 text-gray-700 dark:text-gray-300">
                            {{ $project->description ?? '-' }}</td>
                        <td class="py-3 px-4 border-b border-gray-100 dark:border-gray-800">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $project->visibility === 'public'
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300'
                                    : ($project->visibility === 'team'
                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300'
                                        : 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300') }}">
                                {{ ucfirst($project->visibility) }}
                            </span>
                        </td>
                        <td
                            class="py-3 px-4 border-b border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400">
                            {{ $project->created_at->format('d/m/Y') }}
                        </td>
                        <td class="py-3 px-4 border-b border-gray-100 dark:border-gray-800">
                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="startEdit({{ $project->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button classs="text-red-600 hover:text-red-900" type="button"
                                    wire:click="preDelete({{ $project->id }})" class="text-red-600 hover:text-red-900">
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
                        <td colspan="6" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">No tienes
                            proyectos
                            aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
