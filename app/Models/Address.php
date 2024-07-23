<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Address extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'address';
    protected $fillable = ["address", "latitude", "longitude", "token"];
  
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] =   $value;
    }

    public function setLatitudeAttribute($value)
    {
        $this->attributes['latitude'] = $value;
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = $value;
    }

    public function setTokenAttribute($value)
    {
        $this->attributes['token'] =  $value;
    }
}
