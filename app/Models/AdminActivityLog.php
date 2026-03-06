<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'method',
        'route_name',
        'path',
        'ip_address',
        'user_agent',
        'payload',
        'response_status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}

