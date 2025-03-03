<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplienceScreeningAPIData extends Model
{
    protected $table = "complience_screening_api";
    protected $fillable = [
        'sno',
        'ofac_key',
        'ent_num',
        'name',
        'typeV',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'remarks',
        'type_sort',
        'from_file',
        'source',
        'manual_ofac_id',
        'intEnt',
        'name2',
        'DOB',
        'Metaphone',
        'Alternative_Script',
        'SoundexAplha',
        'DOB_YEAR',
        'DOB_MONTH',
        'Other_Name',
        'insertion_time',
        'modification_time',
        'ACCUITY_UPDATE',
        'is_deleted'
    ];

    protected $casts = [
        'DOB' => 'date',
        'insertion_time' => 'datetime',
        'modification_time' => 'datetime',
        'ACCUITY_UPDATE' => 'datetime',
        'is_deleted' => 'boolean',
    ];
}
