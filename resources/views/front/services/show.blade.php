@extends('layouts.app')

@section('title', $service->title)

@section('content')
<section class="py-24 px-6 max-w-4xl mx-auto">
    <a href="{{ route('services.index') }}" class="text-purple-400 hover:text-purple-300 mb-8 inline-block">&larr; Volver a servicios</a>

    <h1 class="text-4xl font-bold mb-6 anim-hidden" data-anim="fade-up">{{ $service->title }}</h1>

    @if($service->icon)
        <div class="text-5xl mb-6">{{ $service->icon }}</div>
    @endif

    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed anim-hidden" data-anim="fade-up">
        {!! nl2br(e($service->description)) !!}
    </div>
</section>
@endsection
