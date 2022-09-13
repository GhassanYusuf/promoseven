<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class announcements extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'start_date',
        'end_date'
    ];
    
}
