<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\NewLeadNotification;
use App\Mail\SubscriptionWelcome;
use App\Models\Lead;
use App\Models\Service;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('front.contact.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'email'      => 'required|email|max:150',
            'phone'      => 'nullable|string|max:30',
            'service_id' => 'nullable|exists:services,id',
            'budget'     => 'nullable|string|max:50',
            'message'    => 'required|string|max:2000',
        ]);

        // Verificar si hay un lead reciente del mismo email (últimas 24 horas)
        $recentLead = Lead::where('email', $validated['email'])
            ->where('source', 'contact')
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if ($recentLead) {
            return redirect()->route('contact.index')
                ->with('info', 'Ya hemos recibido tu mensaje recientemente. Nos pondremos en contacto contigo pronto.');
        }

        $lead = Lead::create(array_merge($validated, ['source' => 'contact']));
        $lead->load('service');

        try {
            $adminEmail = config('mail.admin_email', config('mail.from.address'));
            Mail::to($adminEmail)->send(new NewLeadNotification($lead));
        } catch (\Exception $e) {
            // Log silencioso - no bloquear al usuario
        }

        return redirect()->route('contact.index')->with('success', '¡Mensaje enviado! Nos pondremos en contacto contigo pronto.');
    }

    /**
     * Almacena un mensaje del chat flotante vía AJAX.
     */
    public function chatStore(Request $request)
    {
        $validated = $request->validate([
            'conversation_id' => 'nullable|string|max:50',
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // Si no hay conversation_id, crear uno nuevo
        $conversationId = $validated['conversation_id'] ?? ChatMessage::generateConversationId();

        $chatMessage = ChatMessage::create([
            'conversation_id' => $conversationId,
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'message'    => $validated['message'],
            'sender'     => 'user',
            'status'     => 'nuevo',
            'is_read'    => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true, 
            'message' => '¡Gracias! Hemos recibido tu mensaje. Te responderemos pronto.',
            'conversation_id' => $conversationId,
            'message_id' => $chatMessage->id,
        ]);
    }

    /**
     * Obtener nuevos mensajes de una conversación (para polling)
     */
    public function getNewMessages(Request $request)
    {
        $conversationId = $request->input('conversation_id');
        $lastMessageId = $request->input('last_message_id', 0);

        if (!$conversationId) {
            return response()->json(['messages' => [], 'has_new' => false]);
        }

        $messages = ChatMessage::where('conversation_id', $conversationId)
            ->where('id', '>', $lastMessageId)
            ->where('sender', 'admin')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'has_new' => $messages->isNotEmpty(),
        ]);
    }

    /**
     * Obtener todos los mensajes de una conversación (para cargar historial)
     */
    public function getConversationHistory(Request $request)
    {
        $conversationId = $request->input('conversation_id');

        if (!$conversationId) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'conversation' => $messages->isNotEmpty() ? [
                'name' => $messages->first()->name,
                'email' => $messages->first()->email,
            ] : null,
        ]);
    }

    /**
     * Suscribirse al boletín (Newsletter)
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:150',
        ]);

        // Verificar si el correo ya está suscrito
        $existingLead = Lead::where('email', $validated['email'])
            ->where('source', 'newsletter')
            ->first();

        if ($existingLead) {
            return response()->json([
                'success' => false,
                'already_subscribed' => true,
                'message' => '¡Este correo ya está suscrito a nuestro boletín! Gracias por tu interés.',
            ], 200);
        }

        // Crear nueva suscripción
        $lead = Lead::create([
            'email'   => $validated['email'],
            'name'    => 'Suscriptor',
            'message' => 'Suscrito al boletín de noticias.',
            'source'  => 'newsletter',
        ]);

        try {
            Mail::to($lead->email)->send(new SubscriptionWelcome($lead));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al enviar correo de bienvenida de newsletter: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => '¡Gracias por suscribirte a nuestro boletín! Revisa tu correo.',
            'lead_id' => $lead->id,
        ]);
    }
}
