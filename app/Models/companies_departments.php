<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies_departments extends Model
{
    use HasFactory;

    protected $fillable = [
        'cid',      // The Company that this department belong to (via ID)
        'mid',      // The user ID of the person managing this department
        'rid',      // The person that the manager of this department report to
        'name'      // Name Of the Department
    ];
}
