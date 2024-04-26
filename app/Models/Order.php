<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'domiciliation',
        'fees',
        'pack_id',
        'lead_id',
        'payTotal',
        'total',
        'userIp'
    ];
}
