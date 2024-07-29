<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    protected $fillable = [
        'email', 'acc_no', 'title', 'nickname', 'first_name', 'mid_name', 'last_name', 'prev_last_name', 'suffix', 'resident', 'resident_citizenship', 'age', 'gender',
        'contact_no', 'contact_last_update', 'contact2_no', 'contact2_last_update', 'occupied_date_permanent', 'birthdate', 'nationality', 'birthcountry', 'birthplace', 'civil_stat', 'branch_id',
        'membership_type', 'application_status', 'membership_status', 'present_residential', 'monthly_present', 'occupied_present', 'last_update_present', 'last_update_permanent',
        'monthly_permanent', 'permanent_address', 'occupied_permanent', 'image', 'image_id_1', 'image_id_2', 'image_sketch', 'image_sketch_2', 'remarks', 'created_at', 'updated_at', 'remarks',
        'height', 'weight', 'approval_date', 'enrollment_date', 'street', 'barangay', 'city', 'province', 'region', 'country', 'postal_code'
    ];

    public function regions()
    {
        return $this->hasMany(region::class, 'country_id', 'country');
    }
    public function provinces()
    {
        return $this->hasMany(region::class, 'region_id', 'region');
    }
    public function cities()
    {
        return $this->hasMany(region::class, 'province_id', 'province');
    }
    public function barangays()
    {
        return $this->hasMany(region::class, 'city_id', 'city');
    }

    public function barangay_object()
    {
        return $this->hasOne(barangay::class, 'id', 'barangay');
    }
    public function city_object()
    {
        return $this->hasOne(city::class, 'id', 'city');
    }
    public function country_object()
    {
        return $this->hasOne(country::class, 'id', 'country');
    }
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

    public function membership_type()
    {
        return $this->hasOne(membership_type::class, 'id', 'membership_type_id');
    }
}
