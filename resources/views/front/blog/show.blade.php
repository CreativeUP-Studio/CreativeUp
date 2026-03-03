@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="py-24 px-6 max-w-3xl mx-auto">
    <a href="{{ route('blog.index') }}" class="text-purple-400 hover:text-purple-300 mb-8 inline-block">&larr; Volver al blog</a>

    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}"
             alt="{{ $post->title }}"
             class="w-full h-72 object-cover rounded-2xl mb-8 anim-hidden" data-anim="fade-up">
    @endif

    <div class="flex items-center gap-3 text-sm text-gray-500 mb-4 anim-hidden" data-anim="fade-up">
        <span>{{ $post->category_label }}</span>
        <span>&middot;</span>
        <span>{{ $post->published_at?->format('d M Y') }}</span>
        <span>&middot;</span>
        <span>{{ $post->read_time }} min lectura</span>
    </div>

    <h1 class="text-4xl font-bold mb-8 anim-hidden" data-anim="fade-up">{{ $post->title }}</h1>

    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed anim-hidden" data-anim="fade-up">
        {!! nl2br(e($post->content)) !!}
    </div>
</article>
@endsection
