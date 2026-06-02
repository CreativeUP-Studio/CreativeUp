<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
        }

        $posts = $query->paginate(10);

        // AJAX Response
        if ($request->ajax()) {
            $allPosts = Post::all();
            $totalWords = $allPosts->sum(function($p) { return str_word_count(strip_tags($p->content)); });
            $totalReadTime = $allPosts->sum(function($p) { return max(1, (int) ceil(str_word_count(strip_tags($p->content)) / 200)); });

            return response()->json([
                'html' => view('admin.posts._posts-grid', compact('posts'))->render(),
                'pagination' => $posts->appends($request->query())->links()->toHtml(),
                'total' => $posts->total(),
                'stats' => [
                    'published' => Post::where('status', 'published')->count(),
                    'draft' => Post::where('status', 'draft')->count(),
                    'total' => Post::count(),
                    'branding' => Post::where('category', 'branding')->count(),
                    'diseno' => Post::where('category', 'diseno')->count(),
                    'seo' => Post::where('category', 'seo')->count(),
                    'redes' => Post::where('category', 'redes')->count(),
                    'marketing' => Post::where('category', 'marketing')->count(),
                    'words' => number_format($totalWords),
                    'reading_time' => $totalReadTime,
                ]
            ]);
        }

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|max:200|unique:posts,slug',
            'content'          => 'required|string',
            'featured_image'   => 'nullable|image|max:2048',
            'category'         => 'nullable|string|in:branding,diseno,seo,redes,marketing',
            'status'           => 'required|in:draft,published',
            'published_at'     => 'nullable|date',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if ($post->status === 'published') {
            \App\Services\NewsletterNotificationService::notifyNewPost($post);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post creado exitosamente.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.posts.edit', $id);
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $wasPublished = $post->status === 'published';

        $validated = $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|max:200|unique:posts,slug,' . $post->id,
            'content'          => 'required|string',
            'featured_image'   => 'nullable|image|max:2048',
            'category'         => 'nullable|string|in:branding,diseno,seo,redes,marketing',
            'status_select'    => 'nullable|in:draft,published',
            'published_at'     => 'nullable|date',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        // Determinar el status basado en el botón presionado o el select
        if ($request->has('action')) {
            $validated['status'] = $request->input('action') === 'publish' ? 'published' : 'draft';
        } elseif ($request->has('status_select')) {
            $validated['status'] = $request->input('status_select');
        } else {
            $validated['status'] = $post->status; // Mantener el status actual
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && !$post->published_at && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remover status_select antes de actualizar
        unset($validated['status_select']);

        $post->update($validated);

        if ($post->status === 'published' && !$wasPublished) {
            \App\Services\NewsletterNotificationService::notifyNewPost($post);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post eliminado exitosamente.');
    }

    public function toggleStatus(Post $post)
    {
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? ($post->published_at ?: now()) : $post->published_at
        ]);

        if ($newStatus === 'published') {
            \App\Services\NewsletterNotificationService::notifyNewPost($post);
        }

        return response()->json([
            'success' => true,
            'status' => $newStatus
        ]);
    }

    public function quickUpdate(Request $request, Post $post)
    {
        $wasPublished = $post->status === 'published';

        $validated = $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|max:200|unique:posts,slug,' . $post->id,
            'category'         => 'nullable|string|in:branding,diseno,seo,redes,marketing',
            'status'           => 'required|in:draft,published',
            'published_at'     => 'nullable|date',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        if ($validated['status'] === 'published' && !$post->published_at && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        if ($post->status === 'published' && !$wasPublished) {
            \App\Services\NewsletterNotificationService::notifyNewPost($post);
        }

        return response()->json([
            'success' => true,
            'post' => $post->fresh(),
            'message' => 'Post actualizado exitosamente.'
        ]);
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'upload' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,webm,ogg,mov,mp3,wav|max:51200', // max 50MB
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $mimeType = $file->getMimeType();
            
            // Determine storage subfolder based on mime type
            if (Str::contains($mimeType, 'video')) {
                $folder = 'videos';
            } elseif (Str::contains($mimeType, 'audio')) {
                $folder = 'audio';
            } else {
                $folder = 'images';
            }
            
            $path = $file->store("blog/{$folder}", 'public');
            $url = asset('storage/' . $path);

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No se cargó ningún archivo.'], 400);
    }
}
