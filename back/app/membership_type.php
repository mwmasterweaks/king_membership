<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class membership_type extends Model
{
    protected $fillable = [
        'name', 'code'
    ];
}
