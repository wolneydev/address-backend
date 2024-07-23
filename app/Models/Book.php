<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{         
    protected $guarded = ['id'];
    protected $table = strtolower('Book');
    protected $fillable = ["name","year"];
}
