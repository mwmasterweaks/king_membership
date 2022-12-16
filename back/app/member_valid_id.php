<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member_valid_id extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_id', 'sss', 'gsis', 'tin','otherID1_type','otherID1_number',
        'otherID1_issued_date','otherID1_expiry_date','otherID1_issue_country',
        'otherID1_issue_by','otherID1_last_update','otherID2_type','otherID2_number','otherID2_issued_date',
        'otherID2_expiry_date','otherID2_issue_country','otherID2_issue_by',
        'otherID2_last_update'
    ];
}
