<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'managerFullName',
        'managerAddress',
        'managerCardId',
        'managerBirth',
        'partner',
        'company_id'
    ];
}
