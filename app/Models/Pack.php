<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'pack_name',
        'pack_description',
        'pack_price',
        'add-ons',
    ];

    function packFeatures() {
        return $this->hasMany(PackFeature::class);
    }
}
