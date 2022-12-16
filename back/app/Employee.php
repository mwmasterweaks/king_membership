<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use App\branch;

class Employee extends Model
{
    protected $fillable = [
        'id', 'group_id', 'rate_id', 'position_id', 'branch_id', 'department_id', 'employment_status',
        'first_name', 'middle_name', 'last_name', 'date_hired', 'img', 'gender',
        'permanent_address', 'tel_no', 'mobile_no', 'email1', 'email2', 'provindial_address',
        'provincial_tel_no', 'birth_date', 'birth_place', 'nationality', 'religion', 'sss_no',
        'pag-ibig', 'prc_license', 'civil_status', 'height', 'weight', 'tin_no', 'philhealth_no',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id', 'id');
    }


    public function branch()
    {
        return $this->hasOne(branch::class, 'id', 'branch_id');
    }
}
