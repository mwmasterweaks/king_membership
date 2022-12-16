<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member_reference extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_id', 'ref1_name', 'ref1_address', 'ref1_contact', 'ref2_name', 'ref2_address', 'ref2_contact'
    ];
}
