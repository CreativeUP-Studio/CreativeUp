{{-- Empty state para cuando no hay contenido --}}
<section class="{{ $class ?? 'py-16' }}">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-lg mx-auto">
            @if($icon ?? false)
            <div class="mb-6 text-gray-600">
                <i class="{{ $icon }} fa-4x"></i>
            </div>
            @endif
            
            <h3 class="text-2xl font-semibold text-gray-300 mb-3">
                {{ $title ?? 'No hay contenido disponible' }}
            </h3>
            
            @if($message ?? false)
            <p class="text-gray-500 mb-6">
                {{ $message }}
            </p>
            @endif
            
            @if($action ?? false)
            <a href="{{ $actionUrl ?? '#' }}" class="btn-ver">
                {{ $action }}
            </a>
            @endif
        </div>
    </div>
</section>
