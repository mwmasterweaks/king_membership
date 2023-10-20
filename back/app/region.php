<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class region extends Model
{
    protected $fillable = [
        'country_id', 'name', 'code', 'description'
    ];

    public function provinces()
    {
        return $this->hasMany(province::class, 'region_id', 'id');
    }

    public function coutry()
    {
        return $this->hasOne(country::class, 'id', 'country_id');
    }
}
