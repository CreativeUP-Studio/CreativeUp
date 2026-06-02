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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(15);

        // Stats
        $stats = [
            'total'     => Lead::count(),
            'new'       => Lead::where('status', 'new')->count(),
            'contacted' => Lead::where('status', 'contacted')->count(),
            'closed'    => Lead::where('status', 'closed')->count(),
            'unread'    => Lead::whereNull('read_at')->count(),
            'high'      => Lead::where('priority', 'high')->count(),
        ];

        // AJAX Response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.leads._leads-table', compact('leads'))->render(),
                'pagination' => $leads->appends($request->query())->links()->toHtml(),
                'total' => $leads->total(),
                'stats' => $stats
            ]);
        }

        return view('admin.leads.index', compact('leads', 'stats'));
    }

    public function show(Lead $lead)
    {
        $lead->load(['service', 'replies.user']);
        $lead->markAsRead();
        return view('admin.leads.show', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status'   => 'sometimes|required|in:new,contacted,closed',
            'priority' => 'sometimes|required|in:low,medium,high',
            'notes'    => 'sometimes|nullable|string|max:5000',
        ]);

        $lead->update($validated);

        return redirect()->back()->with('success', 'Lead actualizado correctamente.');
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

        if ($request->boolean('send_to_email')) {
            try {
                Mail::to($lead->email)->send(new LeadReplyMail($lead, $reply));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Respuesta guardada pero hubo un error al enviar el email: ' . $e->getMessage());
            }
        }

        if ($request->boolean('send_copy')) {
            try {
                Mail::to(auth()->user()->email)->send(new LeadReplyNotification($lead, $reply));
            } catch (\Exception $e) {
                // Silencioso
            }
        }

        if ($lead->status === 'new') {
            $lead->update(['status' => 'contacted']);
        }

        $emailMsg = $request->boolean('send_to_email') ? ' y enviada por email a ' . $lead->email : '';
        return redirect()->back()->with('success', 'Respuesta guardada' . $emailMsg . '.');
    }

    public function export(Request $request)
    {
        $query = Lead::with('service')->withCount('replies')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leads = $query->get();

        $filename = 'leads-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['ID', 'Nombre', 'Email', 'Tel�fono', 'Servicio', 'Presupuesto', 'Estado', 'Prioridad', 'Origen', 'Respuestas', 'Mensaje', 'Fecha']);
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->name,
                    $lead->email,
                    $lead->phone ?? '',
                    $lead->service->title ?? '',
                    $lead->budget ?? '',
                    $lead->status,
                    $lead->priority,
                    $lead->source,
                    $lead->replies_count,
                    str_replace(["\r", "\n"], ' ', $lead->message),
                    $lead->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'bulk_action' => 'required|in:mark_contacted,mark_closed,delete',
            'lead_ids' => 'required|array|min:1',
            'lead_ids.*' => 'exists:leads,id',
        ]);

        $leadIds = $validated['lead_ids'];
        $count = count($leadIds);

        try {
            switch ($validated['bulk_action']) {
                case 'mark_contacted':
                    Lead::whereIn('id', $leadIds)->update(['status' => 'contacted']);
                    $msg = "{$count} lead(s) marcado(s) como contactados.";
                    break;
                    
                case 'mark_closed':
                    Lead::whereIn('id', $leadIds)->update(['status' => 'closed']);
                    $msg = "{$count} lead(s) marcado(s) como cerrados.";
                    break;
                    
                case 'delete':
                    // Eliminar respuestas primero (por si acaso)
                    LeadReply::whereIn('lead_id', $leadIds)->delete();
                    // Luego eliminar los leads
                    Lead::whereIn('id', $leadIds)->delete();
                    $msg = "{$count} lead(s) eliminado(s) correctamente.";
                    break;
            }

            return redirect()->back()->with('success', $msg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la acción: ' . $e->getMessage());
        }
    }

    public function destroy(Lead $lead)
    {
        try {
            $leadName = $lead->name;
            $leadEmail = $lead->email;
            
            // Eliminar respuestas asociadas primero
            $repliesDeleted = $lead->replies()->delete();
            
            // Eliminar el lead
            $lead->delete();
            
            \Illuminate\Support\Facades\Log::info("Lead eliminado: ID {$lead->id}, Nombre: {$leadName}, Email: {$leadEmail}, Respuestas eliminadas: {$repliesDeleted}");
            
            return redirect()->route('admin.leads.index')
                ->with('success', "Lead '{$leadName}' eliminado correctamente.");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al eliminar lead ID {$lead->id}: " . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el lead: ' . $e->getMessage());
        }
    }
}
