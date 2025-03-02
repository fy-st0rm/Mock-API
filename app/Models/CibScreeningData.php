<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CibScreeningData extends Model
{
    protected $table = "cibscreening_datas";
    protected $fillable = [
        'name',
        'dob',
        'gender',
        'father_name',
        'citizenship_number',
        'citizenship_issued_date',
        'citizenship_issued_district',
        'passport_number',
        'passport_expiry_date',
        'driving_license_number',
        'driving_license_issued_date',
        'voter_id_number',
        'voter_id_issued_date',
        'pan',
        'pan_issued_date',
        'pan_issued_district',
        'indian_embassy_number',
        'indian_embassy_reg_date',
        'sector',
        'blacklist_number',
        'blacklisted_date',
        'blacklist_type',
        'pan_number',
        'company_reg_number',
        'company_reg_date',
        'company_reg_auth',
    ];
}
