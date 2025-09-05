<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $primaryKey = 'BookID';
    protected $fillable = ['Title', 'UserID'];

    public function user()
    {
        return $this->belongTo(User::class, 'UserID');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'BookD');
    }

}
