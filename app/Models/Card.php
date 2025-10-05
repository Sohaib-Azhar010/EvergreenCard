<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'header',
        'company_number',
        'membership_number',
        'request_number',
        'valid_until',
        'created_by',
    ];

    protected $casts = [
        'valid_until' => 'date',
    ];
}
