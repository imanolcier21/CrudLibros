<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Book;

class Tasks extends Component
{
    
    public $taskName;
    public $bookId;
    public $taskId;

    
    public $showForm = false;

    
    protected $rules = [
        'taskName' => 'required|string|max:255',
        'bookId' => 'required|integer',
    ];

    public function render()
    {
        
        $tasks = Task::all();
        $books = Book::all();

        return view('livewire.tasks', [
            'tasks' => $tasks,
            'books' => $books,
        ]);
    }

    
    public function create()
    {
        $this->resetInput();
        $this->showForm = true;
    }

    // Método para guardar una nueva tarea o actualizar una existente
    public function save()
    {
        $this->validate();

        
        if ($this->taskId) {
            $task = Task::find($this->taskId);
            $task->update([
                'TaskName' => $this->taskName,
                'BookID' => $this->bookId,
            ]);
            session()->flash('message', 'Tarea actualizada exitosamente.');
        } else {
            // No existe taskId, estamos creando una nueva tarea
            Task::create([
                'TaskName' => $this->taskName,
                'BookID' => $this->bookId,
            ]);
            session()->flash('message', 'Tarea creada exitosamente.');
        }

        $this->showForm = false;
        $this->resetInput();
    }

    // Método para editar una tarea
    public function edit($id)
    {
        $task = Task::find($id);
        $this->taskId = $task->TaskID;
        $this->taskName = $task->TaskName;
        $this->bookId = $task->BookID;
        $this->showForm = true;
    }

    // Método para eliminar una tarea
    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', 'Tarea eliminada exitosamente.');
    }

    
    public function resetInput()
    {
        $this->taskId = null;
        $this->taskName = '';
        $this->bookId = null;
        $this->showForm = false;
    }
}
