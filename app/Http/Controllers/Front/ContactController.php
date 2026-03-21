<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\NewLeadNotification;
use App\Models\Lead;
use App\Models\Service;
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
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $lead = Lead::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'message' => $validated['message'],
            'source'  => 'chat',
            'status'  => 'new',
        ]);

        try {
            $adminEmail = config('mail.admin_email', config('mail.from.address'));
            Mail::to($adminEmail)->send(new NewLeadNotification($lead));
        } catch (\Exception $e) {
            // Log silencioso
        }

        return response()->json(['success' => true, 'message' => '¡Gracias! Nos pondremos en contacto contigo pronto.']);
    }
}
