<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barangay extends Model
{
    protected $fillable = [
        'name', 'code', 'city_id'
    ];

    public function city()
    {
        return $this->hasOne(city::class, 'id', 'city_id');
    }
}
