<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen p-8">
    <div class="container mx-auto max-w-4xl bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Gestión de Libros</h1>

        <!-- Mensaje de éxito -->
        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
        @endif

        <!-- Botón para crear un nuevo libro -->
        <div class="flex justify-end mb-4">
            <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>Añadir Nuevo Libro
            </button>
        </div>

        <!-- Formulario de Creación/Edición -->
        @if ($showForm)
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">{{ $bookId ? 'Editar Libro' : 'Crear Nuevo Libro' }}</h2>
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium mb-2">Título del Libro:</label>
                    <input type="text" id="title" wire:model.defer="title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                        placeholder="Ej. El señor de los anillos">
                    @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center justify-end space-x-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                        {{ $bookId ? 'Guardar Cambios' : 'Guardar Libro' }}
                    </button>
                    <button type="button" wire:click="resetInput" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Lista de libros -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Libros Disponibles</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Título
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($books as $book)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $book->BookID }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $book->Title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $book->BookID }})" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 mr-4">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $book->BookID }})" class="text-red-600 hover:text-red-900 transition-colors duration-200" onclick="confirm('¿Estás seguro de que deseas eliminar este libro?') || event.stopImmediatePropagation()">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No hay libros registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>