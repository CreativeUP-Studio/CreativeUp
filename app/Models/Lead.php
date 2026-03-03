<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'service_id', 'message', 'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function replies()
    {
        return $this->hasMany(LeadReply::class)->latest();
    }
}