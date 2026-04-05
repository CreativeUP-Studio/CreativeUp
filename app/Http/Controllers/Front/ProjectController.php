<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::where('status', 'published')->with('images');

        // Filtro por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%");
            });
        }

        $projects = $query->latest()->paginate(12);

        // Tipos únicos para filtros
        $types = Project::where('status', 'published')
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->pluck('type');

        // AJAX Response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('front.projects._projects-grid', compact('projects'))->render(),
                'pagination' => $projects->links()->toHtml(),
                'total' => $projects->total(),
            ]);
        }

        return view('front.projects.index', compact('projects', 'types'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)
            ->with(['images', 'steps'])
            ->firstOrFail();

        // Proyectos relacionados (mismo tipo, excluyendo el actual)
        $relatedProjects = Project::where('status', 'published')
            ->where('id', '!=', $project->id)
            ->when($project->type, fn($q) => $q->where('type', $project->type))
            ->with('images')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Proyecto anterior y siguiente
        $previousProject = Project::where('status', 'published')
            ->where('id', '<', $project->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextProject = Project::where('status', 'published')
            ->where('id', '>', $project->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('front.projects.show', compact('project', 'relatedProjects', 'previousProject', 'nextProject'));
    }
}
