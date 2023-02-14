<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees_uppraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'eid',
        'did',
        'vid',
        'visa_expire',
        'position',
        'duties',
        'salary',
        'allowances',
        'benefits',
        'documents',
        'start_date',
        'end_date',
        'doneBy',
    ];

}
