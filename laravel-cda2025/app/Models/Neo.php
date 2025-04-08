<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neo extends Model
{
    /** @use HasFactory<\Database\Factories\NeoFactory> */
    use HasFactory;

    protected $fillable = [
        'moto',
        'cigarette',
    ];
}
