<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'logo',
        'cr_number',
        'cr_fileName',
        'cr_fileType',
        'cr_fileUrl ',
        'cr_expire',
        'vat_number',
        'parent_company'
    ];

}
