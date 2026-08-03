<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'hardware_fingerprint',
        'consent_type',
        'device_type',
        'browser',
        'os',
        'cpu_cores',
        'device_memory',
        'connection_type',
        'touch_points',
        'screen_resolution',
        'language',
        'page_url',
        'timezone',
        'user_agent',
        'accepted_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];
}
