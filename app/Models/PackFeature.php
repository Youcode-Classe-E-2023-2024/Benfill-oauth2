<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'pack_id',
        'feature'
    ];

    function pack() {
        return $this->belongsTo(Pack::class);
    }
}
