<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubwayLines extends Model
{         
    protected $guarded = ['id'];
    protected $table = 'subwaylines';
    protected $fillable = ["name","token"];
}
