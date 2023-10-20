<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'province_id'
    ];

    public function barangays()
    {
        return $this->hasMany(barangay::class, 'city_id', 'id');
    }

    public function province()
    {
        return $this->hasOne(province::class, 'id', 'province_id');
    }
}
