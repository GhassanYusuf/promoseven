<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;
    protected $fillable = [
        'eid',
        'name',
        'iso',
        'iso3',
        'numcode',
        'phonecode',
    ];
}
