<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Book;

class Tasks extends Component
{
    public $TaskName;
    public $TaskId;
    public $bookId;

    public $showForm = false;

    protected $rules = [
        'TaskName' => 'required|string|max:255',
        'bookId' => 'required|integer',
    ];

    public function render()
    {
        $Tasks = Task::all();
        $books = Book::all();
        return view('livewire.tasks', [
            'Tasks' => $Tasks,
            'books' => $books,
        ]);
    }

    public function create()
    {
        $this->resetInput();
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->TaskId){
            $Task = Task::find($this->TaskId);
            $Task->update([
                'TaskName' => $this->TaskName,
                'BookID' => $this->bookId,
            ]);
            session()->flash('message', 'Tarea actualizada con éxito');
        }else{
            Task::create([
                'TaskName' => $this->TaskName,
                'BookID' => $this->bookId,
            ]);
            session()->flash('message', 'Tarea creada con éxito');
        }
        $this->showForm = false;
        $this->resetInput();
    }

    public function edit($TaskId)
    {
        $Task = Task::find($TaskId);
        $this->TaskId = $Task->TaskId;
        $this->TaskName = $Task->TaskName;
        $this->bookId = $Task->BookID;
        $this->showForm = true;
    }

    public function delete($TaskId)
    {
        Task::find($TaskId)->delete();
        session()->flash('message', 'Tarea eliminada con éxito');
    }

    public function resetInput()
    {
        $this->TaskName = '';
        $this->TaskId = null;
        $this->bookId = null;
        $this->showForm = false;
    }
}
