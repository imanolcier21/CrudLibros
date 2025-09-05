<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class Books extends Component
{
    
    public $Title;
    public $bookId;

    
    public $showForm = false;

    
    protected $rules = [
        'Title' => 'required|string|max:255',
    ];

    public function render()
    {
        // Obtener todos los libros para la vista
        $books = Book::all();
        return view('livewire.books', ['books' => $books]);
    }

    
    public function create()
    {
        $this->resetInput();
        $this->showForm = true;
    }

    // Método para guardar un nuevo libro o actualizar uno existente
    public function save()
    {
        $validatedData = $this->validate();

        
        if ($this->bookId) {
            $book = Book::find($this->bookId);
            $book->update($validatedData);
            session()->flash('message', 'Libro actualizado exitosamente.');
        } else {
            Book::create([
                'Title' => $validatedData['Title'],
                'UserID' => Auth::id(),
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
        $this->Title = $book->Title;
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
        $this->Title = '';
        $this->showForm = false;
    }
}
