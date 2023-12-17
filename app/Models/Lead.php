<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'preferred_name',
        'email',
        'phone',
        'landline',
        'description',
        'enquired_at',
        'source',
        'status',
        'assigned_to',
        'assigned_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'enquired_at' => 'datetime',
    ];
}
