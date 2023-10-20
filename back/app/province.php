<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    protected $fillable = [
        'name', 'code', 'region_id'
    ];

    public function cities()
    {
        return $this->hasMany(city::class, 'province_id', 'id');
    }

    public function region()
    {
        return $this->hasOne(region::class, 'id', 'region_id');
    }
}
