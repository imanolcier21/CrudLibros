<div class="container mx-auto max-w-4xl bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Gestión de Tareas</h1>

    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-4" role="alert">
        <p>{{ session('message') }}</p>
    </div>
    @endif

    <div class="flex justify-end mb-4">
        <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>Añadir Nueva Tarea
        </button>
    </div>

    @if ($showForm)
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">{{ $taskId ? 'Editar Tarea' : 'Crear Nueva Tarea' }}</h2>
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label for="taskName" class="block text-gray-700 font-medium mb-2">Nombre de la Tarea:</label>
                <input type="text" id="taskName" wire:model.defer="taskName"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                    placeholder="Ej. Escribir capítulo 1">
                @error('taskName') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="bookId" class="block text-gray-700 font-medium mb-2">Libro:</label>
                <select id="bookId" wire:model.defer="bookId"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                    <option value="">Selecciona un libro</option>
                    @foreach ($books as $book)
                    <option value="{{ $book->BookID }}">{{ $book->Title }}</option>
                    @endforeach
                </select>
                @error('bookId') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex items-center justify-end space-x-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                    {{ $taskId ? 'Guardar Cambios' : 'Guardar Tarea' }}
                </button>
                <button type="button" wire:click="resetInput" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Tareas Disponibles</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tarea
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Libro
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $task->TaskID }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $task->TaskName }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $task->book->Title ?? 'Sin Libro' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $task->TaskID }})" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 mr-4">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="delete({{ $task->TaskID }})" class="text-red-600 hover:text-red-900 transition-colors duration-200" onclick="confirm('¿Estás seguro de que deseas eliminar esta tarea?') || event.stopImmediatePropagation()">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No hay tareas registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>