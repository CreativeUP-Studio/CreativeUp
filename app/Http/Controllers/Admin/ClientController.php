<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Listado de clientes (logos) en el admin.
     */
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $clients = $query->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(18)->withQueryString();

        $totalClients    = Client::count();
        $activeClients   = Client::where('is_active', true)->count();
        $inactiveClients = Client::where('is_active', false)->count();

        return view('admin.clients.index', compact(
            'clients',
            'totalClients',
            'activeClients',
            'inactiveClients'
        ));
    }

    /**
     * Formulario de creación (solo logo).
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Guardar nuevo logo de cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo'      => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'name'      => 'nullable|string|max:255',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $path = $request->file('logo')->store('clients', 'public');

        $name = $request->input('name') ?: pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_FILENAME);
        $name = ucwords(str_replace(['_', '-'], ' ', $name));

        Client::create([
            'name'      => $name,
            'logo'      => $path,
            'order'     => $request->input('order', 0),
            'is_active' => $request->has('is_active') ? (bool)$request->input('is_active') : true,
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Logo de cliente subido exitosamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Actualizar logo de cliente.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'name'      => 'nullable|string|max:255',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $data = [
            'name'      => $request->input('name', $client->name),
            'order'     => $request->input('order', $client->order),
            'is_active' => $request->has('is_active') ? (bool)$request->input('is_active') : false,
        ];

        if ($request->hasFile('logo')) {
            if ($client->logo && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }
            $data['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Logo actualizado exitosamente.');
    }

    /**
     * Eliminar cliente.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);

        if ($client->logo && Storage::disk('public')->exists($client->logo)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Logo eliminado exitosamente.');
    }

    /**
     * Alternar estado activo/inactivo.
     */
    public function toggleActive(string $id)
    {
        $client = Client::findOrFail($id);
        $client->is_active = !$client->is_active;
        $client->save();

        return back()->with('success', 'Estado del logo actualizado.');
    }
}
