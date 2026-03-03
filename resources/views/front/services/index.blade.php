@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
<section class="py-24 px-6 max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-4 anim-hidden" data-anim="fade-up">Nuestros Servicios</h1>
    <p class="text-gray-400 mb-12 max-w-2xl anim-hidden" data-anim="fade-up">
        Soluciones creativas y estratégicas para impulsar tu marca al siguiente nivel.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($services as $service)
            <a href="{{ route('services.show', $service->slug) }}"
               class="block bg-gray-900 rounded-2xl p-8 hover:bg-gray-800 transition-colors anim-scroll"
               data-anim="fade-up">
                @if($service->icon)
                    <div class="text-4xl mb-4">{{ $service->icon }}</div>
                @endif
                <h2 class="text-2xl font-semibold mb-3">{{ $service->title }}</h2>
                <p class="text-gray-400 leading-relaxed">{{ Str::limit($service->description, 150) }}</p>
                <span class="inline-block mt-4 text-purple-400 font-medium">Ver más &rarr;</span>
            </a>
        @empty
            <p class="text-gray-500 col-span-2">No hay servicios disponibles por el momento.</p>
        @endforelse
    </div>
</section>
@endsection
