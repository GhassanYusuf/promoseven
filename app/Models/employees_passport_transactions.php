<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees_passport_transactions extends Model
{
    use HasFactory;

    protected $table = 'employees_passport_transactions';

    protected $fillable = [
        'eid',
        'type',
        'state',
        'note',
        'done_by',
    ];

}
