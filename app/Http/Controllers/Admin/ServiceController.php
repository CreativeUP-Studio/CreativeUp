<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('leads')->latest()->paginate(10);
        $totalServices = Service::count();
        $activeServices = Service::where('is_active', true)->count();
        $inactiveServices = Service::where('is_active', false)->count();
        $totalLeads = \App\Models\Lead::whereNotNull('service_id')->count();
        
        return view('admin.services.index', compact('services', 'totalServices', 'activeServices', 'inactiveServices', 'totalLeads'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:150',
            'slug'              => 'nullable|string|max:150|unique:services,slug',
            'description'       => 'required|string',
            'short_description' => 'nullable|string|max:300',
            'icon'              => 'nullable|string|max:255',
            'image'             => 'nullable|image|max:2048',
            'gallery'           => 'nullable|array|max:8',
            'gallery.*'         => 'image|max:2048',
            'features'          => 'nullable|array|max:10',
            'features.*'        => 'string|max:255',
            'benefits'          => 'nullable|array|max:6',
            'benefits.*.title'  => 'string|max:100',
            'benefits.*.desc'   => 'string|max:300',
            'benefits.*.icon'   => 'nullable|string|max:50',
            'process_steps'           => 'nullable|array|max:6',
            'process_steps.*.title'   => 'string|max:100',
            'process_steps.*.desc'    => 'string|max:300',
            'cta_text'          => 'nullable|string|max:255',
            'meta_title'        => 'nullable|string|max:200',
            'meta_description'  => 'nullable|string|max:500',
            'color'             => 'nullable|string|max:7',
            'order'             => 'nullable|integer|min:0',
            'is_active'         => 'nullable',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_active'] = $request->input('is_active') == '1';
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        // Gallery
        if ($request->hasFile('gallery')) {
            $paths = [];
            foreach ($request->file('gallery') as $file) {
                $paths[] = $file->store('services/gallery', 'public');
            }
            $validated['gallery'] = $paths;
        }

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features'], fn($f) => trim($f) !== ''));
        }

        // Filter empty benefits
        if (isset($validated['benefits'])) {
            $validated['benefits'] = array_values(array_filter($validated['benefits'], fn($b) => !empty(trim($b['title'] ?? ''))));
        }

        // Filter empty process steps
        if (isset($validated['process_steps'])) {
            $validated['process_steps'] = array_values(array_filter($validated['process_steps'], fn($s) => !empty(trim($s['title'] ?? ''))));
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.services.edit', $id);
    }

    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'title'             => 'required|string|max:150',
            'slug'              => 'nullable|string|max:150|unique:services,slug,' . $service->id,
            'description'       => 'required|string',
            'short_description' => 'nullable|string|max:300',
            'icon'              => 'nullable|string|max:255',
            'image'             => 'nullable|image|max:2048',
            'gallery'           => 'nullable|array|max:8',
            'gallery.*'         => 'image|max:2048',
            'features'          => 'nullable|array|max:10',
            'features.*'        => 'string|max:255',
            'benefits'          => 'nullable|array|max:6',
            'benefits.*.title'  => 'string|max:100',
            'benefits.*.desc'   => 'string|max:300',
            'benefits.*.icon'   => 'nullable|string|max:50',
            'process_steps'           => 'nullable|array|max:6',
            'process_steps.*.title'   => 'string|max:100',
            'process_steps.*.desc'    => 'string|max:300',
            'cta_text'          => 'nullable|string|max:255',
            'meta_title'        => 'nullable|string|max:200',
            'meta_description'  => 'nullable|string|max:500',
            'color'             => 'nullable|string|max:7',
            'order'             => 'nullable|integer|min:0',
            'is_active'         => 'nullable',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_active'] = $request->input('is_active') == '1';
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        } else {
            unset($validated['image']);
        }

        // Gallery: merge new uploads with existing, handle removals
        $existingGallery = $service->gallery ?? [];
        $removeGallery = $request->input('remove_gallery', []);
        foreach ($removeGallery as $path) {
            Storage::disk('public')->delete($path);
            $existingGallery = array_values(array_filter($existingGallery, fn($g) => $g !== $path));
        }
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $existingGallery[] = $file->store('services/gallery', 'public');
            }
        }
        $validated['gallery'] = array_values($existingGallery);

        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features'], fn($f) => trim($f) !== ''));
        }

        if (isset($validated['benefits'])) {
            $validated['benefits'] = array_values(array_filter($validated['benefits'], fn($b) => !empty(trim($b['title'] ?? ''))));
        }

        if (isset($validated['process_steps'])) {
            $validated['process_steps'] = array_values(array_filter($validated['process_steps'], fn($s) => !empty(trim($s['title'] ?? ''))));
        }

        if ($request->has('remove_image') && !$request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = null;
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        if ($service->gallery) {
            foreach ($service->gallery as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Servicio eliminado exitosamente.');
    }
}
