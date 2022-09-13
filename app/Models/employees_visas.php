<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees_visas extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'cr',
        'cr_attach',
        'cr_expire',
        'vat_number',
        'created_at',
        'updated_at'
    ];

}
