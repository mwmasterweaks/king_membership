<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    protected $fillable = [
        'email', 'acc_no', 'title','nickname','first_name', 'mid_name', 'last_name', 'prev_last_name', 'suffix', 'resident', 'resident_citizenship','age', 'gender',
        'contact_no', 'contact_last_update','contact2_no', 'contact2_last_update','occupied_date_permanent', 'birthdate', 'nationality', 'birthcountry', 'birthplace', 'civil_stat', 'branch_id',
        'application_status', 'membership_status', 'present_residential', 'monthly_present','occupied_present', 'last_update_present', 'last_update_permanent',
       'monthly_permanent','permanent_address', 'occupied_permanent', 'image','image_id_1','image_id_2','image_sketch','image_sketch_2','remarks', 'created_at', 'updated_at','remarks'
    ];

    public function branch()
    {
        return $this->hasOne(branch::class, 'id', 'branch_id');
    }
    public function member_details()
    {
        return $this->hasOne(member_detail::class, 'member_id', 'id');
    }
    public function member_reference()
    {
        return $this->hasOne(member_reference::class, 'member_id', 'id');
    }
    public function member_valid()
    {
        return $this->hasOne(member_valid_id::class, 'member_id', 'id');
    }
}
