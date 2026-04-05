<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter (based on slug keywords)
        if ($request->filled('category')) {
            $category = $request->category;
            $categoryKeywords = [
                'branding' => ['branding', 'marca', 'brand', 'logo', 'identidad'],
                'diseno' => ['diseño', 'diseno', 'design', 'web', 'ui', 'ux'],
                'seo' => ['seo', 'posicionamiento', 'search', 'google', 'optimizacion'],
                'redes' => ['redes', 'social', 'facebook', 'instagram', 'marketing'],
            ];
            
            if (isset($categoryKeywords[$category])) {
                $keywords = $categoryKeywords[$category];
                $query->where(function($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('slug', 'like', "%{$keyword}%")
                          ->orWhere('title', 'like', "%{$keyword}%");
                    }
                });
            }
        }

        $posts = $query->latest('published_at')->paginate(9);

        // AJAX Response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('front.blog._posts-grid', compact('posts'))->render(),
                'pagination' => $posts->links()->toHtml(),
                'total' => $posts->total(),
                'stats' => [
                    'total' => $posts->total(),
                    'showing' => $posts->count(),
                ]
            ]);
        }

        return view('front.blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('front.blog.show', compact('post'));
    }
}
