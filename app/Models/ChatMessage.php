<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatMessage extends Model
{
    protected $fillable = [
        'conversation_id',
        'name',
        'email',
        'message',
        'sender',
        'status',
        'is_read',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method - auto-generate conversation_id if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($message) {
            if (empty($message->conversation_id)) {
                $message->conversation_id = self::generateConversationId();
            }
        });
    }

    // Scopes
    public function scopeConversation($query, $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false)->where('sender', 'user');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Métodos estáticos
    public static function generateConversationId()
    {
        return 'conv_' . Str::random(32);
    }

    public static function getConversations()
    {
        $conversations = self::select('conversation_id')
            ->whereNotNull('conversation_id')
            ->where('conversation_id', '!=', '')
            ->selectRaw('MAX(name) as name')
            ->selectRaw('MAX(email) as email')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('COUNT(*) as message_count')
            ->selectRaw('SUM(CASE WHEN is_read = 0 AND sender = "user" THEN 1 ELSE 0 END) as unread_count')
            ->selectRaw('(SELECT message FROM chat_messages cm WHERE cm.conversation_id = chat_messages.conversation_id AND cm.sender = "user" ORDER BY cm.created_at DESC LIMIT 1) as last_user_message')
            ->groupBy('conversation_id')
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        // Convertir last_message_at a Carbon
        $conversations->transform(function ($conversation) {
            $conversation->last_message_at = \Carbon\Carbon::parse($conversation->last_message_at);
            return $conversation;
        });
        
        return $conversations;
    }

    public static function getConversationMessages($conversationId)
    {
        return self::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public static function markConversationAsRead($conversationId)
    {
        return self::where('conversation_id', $conversationId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}
