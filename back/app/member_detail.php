<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member_detail extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_id', 'acc_no', 'dependents_no', 'children_no', 'household_no', 'spouse_name', 'spouse_age', 'spouse_occupation',
        'spouse_employer', 'spouse_address','mother_title', 'mother_first_name', 'mother_mid_name', 'mother_last_name', 'mother_suffix','father_title',
        'father_first_name', 'father_mid_name', 'father_last_name', 'father_suffix', 'owned_properties', 'owned_cars', 'ownership_present','ownership_permanent',
        'income_source', 'income_via', 'other_income_via', 'emp_employer', 'emp_nature', 'emp_tin', 'emp_tel_no', 'emp_address',
        'emp_position', 'emp_date_employed', 'emp_gross', 'emp_currency', 'emp_period', 'emp_annual', 'emp_occ_status', 'bn_name', 'bn_nature',
        'bn_established', 'bn_tin', 'bn_address', 'bn_contact','benef_name_1', 'benef_age_1', 'benef_relation_1', 'benef_contact_1', 'benef_name_2', 'benef_age_2', 'benef_relation_2', 'benef_contact_2'

    ];
}
