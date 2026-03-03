@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<section class="py-24 px-6 max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-4 anim-hidden" data-anim="fade-up">Blog</h1>
    <p class="text-gray-400 mb-12 max-w-2xl anim-hidden" data-anim="fade-up">
        Ideas, tendencias y estrategias del mundo creativo y digital.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}"
               class="block bg-gray-900 rounded-2xl overflow-hidden hover:bg-gray-800 transition-colors anim-scroll"
               data-anim="fade-up">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-purple-900 to-indigo-900 flex items-center justify-center">
                        <span class="text-purple-300 text-sm">{{ $post->category_label }}</span>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>{{ $post->published_at?->format('d M Y') }}</span>
                        <span>&middot;</span>
                        <span>{{ $post->read_time }} min lectura</span>
                    </div>
                    <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-400 text-sm">{{ $post->excerpt }}</p>
                </div>
            </a>
        @empty
            <p class="text-gray-500 col-span-3">No hay publicaciones disponibles por el momento.</p>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $posts->links() }}
    </div>
</section>
@endsection
