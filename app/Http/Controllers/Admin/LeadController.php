<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LeadReplyMail;
use App\Mail\LeadReplyNotification;
use App\Models\Lead;
use App\Models\LeadReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with('service')->withCount('replies')->latest();

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(15);

        return view('admin.leads.index', compact('leads'));
    }

    public function show(Lead $lead)
    {
        $lead->load(['service', 'replies.user']);
        return view('admin.leads.show', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,closed',
        ]);

        $lead->update($validated);

        return redirect()->back()->with('success', 'Estado del lead actualizado.');
    }

    public function reply(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'message'       => 'required|string|max:5000',
            'send_to_email' => 'nullable|boolean',
            'send_copy'     => 'nullable|boolean',
        ]);

        $reply = LeadReply::create([
            'lead_id'       => $lead->id,
            'user_id'       => auth()->id(),
            'message'       => $validated['message'],
            'sent_to_email' => $request->boolean('send_to_email'),
        ]);

        $reply->load('user');

        // Enviar email al lead
        if ($request->boolean('send_to_email')) {
            try {
                Mail::to($lead->email)->send(new LeadReplyMail($lead, $reply));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Respuesta guardada pero hubo un error al enviar el email: ' . $e->getMessage());
            }
        }

        // Enviar copia al admin
        if ($request->boolean('send_copy')) {
            try {
                Mail::to(auth()->user()->email)->send(new LeadReplyNotification($lead, $reply));
            } catch (\Exception $e) {
                // No bloquear si falla la copia
            }
        }

        // Actualizar estado a contactado si estaba en nuevo
        if ($lead->status === 'new') {
            $lead->update(['status' => 'contacted']);
        }

        $emailMsg = $request->boolean('send_to_email') ? ' y enviada por email a ' . $lead->email : '';
        return redirect()->back()->with('success', 'Respuesta guardada' . $emailMsg . '.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead eliminado exitosamente.');
    }
}
