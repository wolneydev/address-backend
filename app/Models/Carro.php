<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Carro extends Model
{         
    protected $guarded = ['id'];
    protected $table = strtolower('Carro');
    protected $fillable = ["ano","nome"];
}
