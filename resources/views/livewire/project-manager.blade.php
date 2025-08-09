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
                    class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2 rounded-lg font-semibold font-sans shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 dark:focus:ring-offset-gray-800">
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
                                    class="bg-blue-500 hover:bg-blue-600 text-white rounded-full text-center text-xs font-semibold px-3 py-1 shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 dark:focus:ring-offset-gray-800">
                                    Editar
                                </button>
                                <button type="button" wire:click="preDelete({{ $project->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white rounded-full text-center text-xs font-semibold px-2 shadow transition py-1 font-mono focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 flex justify-center items-center dark:focus:ring-offset-gray-800 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <g>
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M7 6V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5zm6.414 8l1.768-1.768-1.414-1.414L12 12.586l-1.768-1.768-1.414 1.414L10.586 14l-1.768 1.768 1.414 1.414L12 15.414l1.768 1.768 1.414-1.414L13.414 14zM9 4v2h6V4H9z" />
                                        </g>
                                    </svg>
                                    <span class="text-xs px-1">Eliminar</span>
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
