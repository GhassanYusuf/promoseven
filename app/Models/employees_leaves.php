<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees_leaves extends Model
{
    use HasFactory;
    protected $fillable = [
        'eid',
        'type',
        'start_date',
        'return_date',
        'status',
        'employee_incharge',
        'annual_ticket',
        'destination',
        'flight_details',
        'contact_info',
        'note',
        'hApproval',
        'mApproval',
        'hApproved_by',
        'mApproved_by',
    ];

}
