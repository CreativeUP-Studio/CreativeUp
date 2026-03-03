@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<section class="py-24 px-6 max-w-3xl mx-auto">
    <h1 class="text-4xl font-bold mb-4 anim-hidden" data-anim="fade-up">Contáctanos</h1>
    <p class="text-gray-400 mb-12 anim-hidden" data-anim="fade-up">
        ¿Tienes un proyecto en mente? Cuéntanos y hagamos algo increíble juntos.
    </p>

    @if(session('success'))
        <div class="bg-green-900/30 border border-green-700 text-green-300 rounded-xl p-4 mb-8">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-900/30 border border-red-700 text-red-300 rounded-xl p-4 mb-8">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6 anim-scroll" data-anim="fade-up">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nombre *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 focus:outline-none transition-colors">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 focus:outline-none transition-colors">
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Teléfono</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                   class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 focus:outline-none transition-colors">
        </div>

        <div>
            <label for="service_id" class="block text-sm font-medium text-gray-300 mb-2">Servicio de interés</label>
            <select id="service_id" name="service_id"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 focus:outline-none transition-colors">
                <option value="">Selecciona un servicio</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Mensaje *</label>
            <textarea id="message" name="message" rows="5" required
                      class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 focus:outline-none transition-colors resize-y">{{ old('message') }}</textarea>
        </div>

        <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
            Enviar mensaje
        </button>
    </form>
</section>
@endsection
