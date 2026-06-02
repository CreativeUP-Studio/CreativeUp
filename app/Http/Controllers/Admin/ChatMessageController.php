<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    /**
     * Lista de conversaciones
     */
    public function index()
    {
        $conversations = ChatMessage::getConversations();
        $totalUnread = ChatMessage::unread()->count();
        
        return view('admin.chat.index', compact('conversations', 'totalUnread'));
    }

    /**
     * Ver conversación específica
     */
    public function show($conversationId)
    {
        $messages = ChatMessage::getConversationMessages($conversationId);
        
        if ($messages->isEmpty()) {
            return redirect()->route('admin.chat.index')
                ->with('error', 'Conversación no encontrada');
        }

        // Marcar mensajes como leídos
        ChatMessage::markConversationAsRead($conversationId);

        $conversation = $messages->first();
        
        return view('admin.chat.show', compact('messages', 'conversation', 'conversationId'));
    }

    /**
     * Enviar respuesta en la conversación
     */
    public function reply(Request $request, $conversationId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $conversation = ChatMessage::where('conversation_id', $conversationId)->first();
        
        if (!$conversation) {
            return response()->json(['error' => 'Conversación no encontrada'], 404);
        }

        $message = ChatMessage::create([
            'conversation_id' => $conversationId,
            'name' => 'Admin',
            'email' => auth()->user()->email ?? 'admin@creativeup.com',
            'message' => $validated['message'],
            'sender' => 'admin',
            'status' => 'respondido',
            'is_read' => true,
        ]);

        // Actualizar el status de la conversación
        ChatMessage::where('conversation_id', $conversationId)
            ->update(['status' => 'respondido']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.chat.show', $conversationId)
            ->with('success', 'Respuesta enviada correctamente');
    }

    /**
     * Obtener nuevos mensajes (para polling)
     */
    public function getNewMessages(Request $request, $conversationId)
    {
        $lastMessageId = $request->input('last_message_id', 0);
        
        $messages = ChatMessage::where('conversation_id', $conversationId)
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Marcar como leídos
        ChatMessage::where('conversation_id', $conversationId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $messages,
            'has_new' => $messages->isNotEmpty(),
        ]);
    }

    /**
     * Eliminar conversación
     */
    public function destroy($conversationId)
    {
        ChatMessage::where('conversation_id', $conversationId)->delete();
        
        return redirect()->route('admin.chat.index')
            ->with('success', 'Conversación eliminada correctamente');
    }

    /**
     * Obtener notificaciones en tiempo real
     */
    public function getNotifications(Request $request)
    {
        $lastCheck = $request->input('last_check', now()->subMinutes(5));
        
        // Obtener mensajes no leídos
        $unreadCount = ChatMessage::unread()->count();
        
        // Obtener leads nuevos
        $leadsCount = \App\Models\Lead::where('status', 'nuevo')->count();
        
        // Total de notificaciones
        $totalUnread = $unreadCount + $leadsCount;
        
        // Obtener mensajes recientes del chat (últimos 5)
        $recentChatMessages = ChatMessage::select('conversation_id', 'name', 'email', 'message', 'created_at')
            ->where('sender', 'user')
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Obtener nuevas conversaciones (últimos 5 minutos)
        $newConversations = ChatMessage::select('conversation_id', 'name', 'email', 'message', 'created_at')
            ->whereNotNull('conversation_id')
            ->where('conversation_id', '!=', '')
            ->where('sender', 'user')
            ->where('created_at', '>', $lastCheck)
            ->whereRaw('id = (SELECT MIN(id) FROM chat_messages cm WHERE cm.conversation_id = chat_messages.conversation_id)')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Obtener nuevos mensajes en conversaciones existentes
        $newMessages = ChatMessage::select('conversation_id', 'name', 'email', 'message', 'created_at')
            ->whereNotNull('conversation_id')
            ->where('conversation_id', '!=', '')
            ->where('sender', 'user')
            ->where('is_read', false)
            ->where('created_at', '>', $lastCheck)
            ->whereRaw('id != (SELECT MIN(id) FROM chat_messages cm WHERE cm.conversation_id = chat_messages.conversation_id)')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json([
            'unread_count' => $totalUnread,
            'chat_unread_count' => $unreadCount,
            'leads_count' => $leadsCount,
            'recent_chat_messages' => $recentChatMessages,
            'new_conversations' => $newConversations,
            'new_messages' => $newMessages,
            'timestamp' => now()->toIso8601String()
        ]);
    }
    
    /**
     * Marcar todos los mensajes como leídos
     */
    public function markAllAsRead()
    {
        ChatMessage::where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones han sido marcadas como leídas'
        ]);
    }
}
