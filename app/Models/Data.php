<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Add other attributes as necessary
        'latitude',
        'longitude',
        'time',
        'date',
    ];
}
