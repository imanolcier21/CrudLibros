<?php

use App\Livewire\Books;
use App\Livewire\Tasks;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
route::get('/books', Books::class)->name('books.index');
route::get('/tasks', Tasks::class)->name('tasks.index');


require __DIR__.'/auth.php';
