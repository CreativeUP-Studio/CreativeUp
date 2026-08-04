<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        $query = JobOffer::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('area')) {
            $query->where('area', $request->input('area'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $jobOffers = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $totalJobs = JobOffer::count();
        $activeJobs = JobOffer::where('is_active', true)->count();
        $inactiveJobs = JobOffer::where('is_active', false)->count();

        return view('admin.job_offers.index', compact(
            'jobOffers',
            'totalJobs',
            'activeJobs',
            'inactiveJobs'
        ));
    }

    public function create()
    {
        return view('admin.job_offers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:job_offers,slug',
            'area'         => 'required|string|max:100',
            'type'         => 'required|string|max:100',
            'location'     => 'required|string|max:100',
            'description'  => 'required|string',
            'requirements' => 'nullable|string',
            'order'        => 'nullable|integer|min:0',
            'is_active'    => 'nullable',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_active'] = $request->input('is_active') == '1';
        $validated['order'] = $validated['order'] ?? 0;

        JobOffer::create($validated);

        return redirect()->route('admin.job-offers.index')->with('success', 'Puesto de trabajo creado exitosamente.');
    }

    public function edit(string $id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        return view('admin.job_offers.edit', compact('jobOffer'));
    }

    public function update(Request $request, string $id)
    {
        $jobOffer = JobOffer::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:job_offers,slug,' . $jobOffer->id,
            'area'         => 'required|string|max:100',
            'type'         => 'required|string|max:100',
            'location'     => 'required|string|max:100',
            'description'  => 'required|string',
            'requirements' => 'nullable|string',
            'order'        => 'nullable|integer|min:0',
            'is_active'    => 'nullable',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_active'] = $request->input('is_active') == '1';
        $validated['order'] = $validated['order'] ?? 0;

        $jobOffer->update($validated);

        return redirect()->route('admin.job-offers.index')->with('success', 'Puesto de trabajo actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        $jobOffer->delete();

        return redirect()->route('admin.job-offers.index')->with('success', 'Puesto de trabajo eliminado exitosamente.');
    }

    public function toggleActive(JobOffer $jobOffer)
    {
        $jobOffer->update([
            'is_active' => !$jobOffer->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $jobOffer->is_active
        ]);
    }
}
