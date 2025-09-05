<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;

class Books extends Component
{
    // Propiedades del formulario
    public $title;
    public $bookId;

    // Propiedad para mostrar/ocultar el modal de edición
    public $showForm = false;

    // Reglas de validación
    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    public function render()
    {
        // Obtener todos los libros para la vista
        $books = Book::all();
        return view('livewire.books', ['books' => $books]);
    }

    // Método para abrir el formulario de creación
    public function create()
    {
        $this->resetInput();
        $this->showForm = true;
    }

    // Método para guardar un nuevo libro o actualizar uno existente
    public function save()
    {
        $this->validate();

        // Si existe bookId, estamos actualizando
        if ($this->bookId) {
            $book = Book::find($this->bookId);
            $book->update([
                'title' => $this->title,
            ]);
            session()->flash('message', 'Libro actualizado exitosamente.');
        } else {
            // No existe bookId, estamos creando uno nuevo
            Book::create([
                'title' => $this->title,
                // Asignar un UserID. Aquí podrías usar el ID del usuario autenticado.
                'UserID' => 1, // Cambia esto para usar Auth::id() en una aplicación real
            ]);
            session()->flash('message', 'Libro creado exitosamente.');
        }

        $this->showForm = false;
        $this->resetInput();
    }

    // Método para editar un libro
    public function edit($id)
    {
        $book = Book::find($id);
        $this->bookId = $book->BookID;
        $this->title = $book->Title;
        $this->showForm = true;
    }

    // Método para eliminar un libro
    public function delete($id)
    {
        Book::find($id)->delete();
        session()->flash('message', 'Libro eliminado exitosamente.');
    }

    // Método para resetear las propiedades del formulario
    public function resetInput()
    {
        $this->bookId = null;
        $this->title = '';
        $this->showForm = false;
    }
}
