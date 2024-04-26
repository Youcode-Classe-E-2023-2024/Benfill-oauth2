<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'managerEmail',
        'managerFullName',
        'managerGender',
        'managerPhone',
        'companyName',
        'activity',
        'address',
        'capital',
        'structure',
        'accountant',
        'nonPartnerManager',
        'delay_creation',
        'needs',
    ];
}
