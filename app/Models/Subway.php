<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SubwayLines;


class Subway extends Model
{         
    protected $guarded = ['id'];
    protected $table='subway';
    protected $fillable = ["address_id","name","token","subwayline_id"];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }   
    public function subwayline(): BelongsTo
    {
        return $this->belongsTo(SubwayLines::class,'subwayline_id', 'id');
    }       
}
