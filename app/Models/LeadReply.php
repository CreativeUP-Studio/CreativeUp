<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadReply extends Model
{
    protected $fillable = [
        'lead_id',
        'user_id',
        'message',
        'sent_to_email',
    ];

    protected $casts = [
        'sent_to_email' => 'boolean',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
