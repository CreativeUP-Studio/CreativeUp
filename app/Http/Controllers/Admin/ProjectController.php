<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('images')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:projects,slug',
            'description' => 'required|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|string',
            'type' => 'nullable|string|max:80',
            'client' => 'nullable|string|max:150',
            'year' => 'nullable|string|max:10',
            'technologies' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'images.*' => 'image|max:2048',
        ]);

        // Convertir technologies de texto a array
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        unset($validated['images']);
        $project = Project::create($validated);

        // Guardar imágenes adicionales
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects/images', 'public');
                $project->images()->create(['image_path' => $path]);
            }
        }

        // Guardar pasos del proceso
        if ($request->has('steps')) {
            foreach ($request->steps as $index => $stepData) {
                if (empty($stepData['title'])) continue;
                $step = $project->steps()->create([
                    'title' => $stepData['title'],
                    'description' => $stepData['description'] ?? '',
                    'order' => $index,
                ]);
                for ($i = 1; $i <= 3; $i++) {
                    if ($request->hasFile("steps.{$index}.image{$i}")) {
                        $path = $request->file("steps.{$index}.image{$i}")->store('projects/steps', 'public');
                        $step->update(["image{$i}" => $path]);
                    }
                }
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto creado exitosamente.');
    }

    public function show(string $id)
    {
        $project = Project::with(['images', 'steps'])->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    public function edit(string $id)
    {
        $project = Project::with(['images', 'steps'])->findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:projects,slug,' . $project->id,
            'description' => 'required|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|string',
            'type' => 'nullable|string|max:80',
            'client' => 'nullable|string|max:150',
            'year' => 'nullable|string|max:10',
            'technologies' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'images.*' => 'image|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:project_images,id',
        ]);

        // Convertir technologies de texto a array
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            // Eliminar thumbnail anterior
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        if ($validated['status'] === 'published' && !$project->published_at && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Eliminar imágenes marcadas
        if ($request->filled('delete_images')) {
            $imagesToDelete = ProjectImage::whereIn('id', $request->delete_images)->where('project_id', $project->id)->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        unset($validated['images'], $validated['delete_images']);
        $project->update($validated);

        // Agregar nuevas imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects/images', 'public');
                $project->images()->create(['image_path' => $path]);
            }
        }

        // Actualizar pasos del proceso
        if ($request->has('steps')) {
            // Eliminar pasos marcados para borrar
            if ($request->filled('delete_steps')) {
                $stepsToDelete = ProjectStep::whereIn('id', $request->delete_steps)->where('project_id', $project->id)->get();
                foreach ($stepsToDelete as $s) {
                    for ($i = 1; $i <= 3; $i++) {
                        if ($s->{"image{$i}"}) Storage::disk('public')->delete($s->{"image{$i}"});
                    }
                    $s->delete();
                }
            }

            foreach ($request->steps as $index => $stepData) {
                if (empty($stepData['title'])) continue;

                if (!empty($stepData['id'])) {
                    // Actualizar paso existente
                    $step = ProjectStep::where('id', $stepData['id'])->where('project_id', $project->id)->first();
                    if ($step) {
                        $step->update([
                            'title' => $stepData['title'],
                            'description' => $stepData['description'] ?? '',
                            'order' => $index,
                        ]);
                        for ($i = 1; $i <= 3; $i++) {
                            if ($request->hasFile("steps.{$index}.image{$i}")) {
                                if ($step->{"image{$i}"}) Storage::disk('public')->delete($step->{"image{$i}"});
                                $path = $request->file("steps.{$index}.image{$i}")->store('projects/steps', 'public');
                                $step->update(["image{$i}" => $path]);
                            }
                        }
                    }
                } else {
                    // Crear nuevo paso
                    $step = $project->steps()->create([
                        'title' => $stepData['title'],
                        'description' => $stepData['description'] ?? '',
                        'order' => $index,
                    ]);
                    for ($i = 1; $i <= 3; $i++) {
                        if ($request->hasFile("steps.{$index}.image{$i}")) {
                            $path = $request->file("steps.{$index}.image{$i}")->store('projects/steps', 'public');
                            $step->update(["image{$i}" => $path]);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $project = Project::with(['images', 'steps'])->findOrFail($id);

        // Eliminar archivos
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        foreach ($project->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        foreach ($project->steps as $step) {
            for ($i = 1; $i <= 3; $i++) {
                if ($step->{"image{$i}"}) Storage::disk('public')->delete($step->{"image{$i}"});
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto eliminado exitosamente.');
    }
}
