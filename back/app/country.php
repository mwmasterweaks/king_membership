<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $fillable = [
        'name', 'code'
    ];

    public function regions()
    {
        return $this->hasMany(region::class, 'country_id', 'id');
    }
}
