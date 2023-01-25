<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $table = 'employees_attachments';
    protected $fillable = [
        'title',
        'name',
        'type',
        'path',
        'eid',
        'done_by'
    ];
}
