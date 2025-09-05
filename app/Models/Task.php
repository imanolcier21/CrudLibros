<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'TaskId';
    protected $fillable = ['TaskName', 'BookID'];

    public function book()
    {

        return $this->belongsTo(Book::class, 'BookID');
    }
}
