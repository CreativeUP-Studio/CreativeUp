<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'service_id', 'message',
        'budget', 'notes', 'source', 'priority', 'status', 'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Eliminar respuestas asociadas al eliminar un lead
        static::deleting(function ($lead) {
            $lead->replies()->delete();
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function replies()
    {
        return $this->hasMany(LeadReply::class)->latest();
    }

    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }
}