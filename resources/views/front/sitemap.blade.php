{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemap.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    {{-- Home --}}
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Sobre Nosotros --}}
    <url>
        <loc>{{ route('about') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    {{-- Servicios Index --}}
    <url>
        <loc>{{ route('services.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    {{-- Portafolio / Proyectos Index --}}
    <url>
        <loc>{{ route('projects.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    {{-- Blog Index --}}
    <url>
        <loc>{{ route('blog.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    {{-- Contacto --}}
    <url>
        <loc>{{ route('contact.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    {{-- Trabaja con Nosotros / Carreras --}}
    <url>
        <loc>{{ route('careers') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    {{-- Servicios Individuales --}}
    @foreach($services as $svc)
    <url>
        <loc>{{ route('services.show', $svc->slug) }}</loc>
        <lastmod>{{ $svc->updated_at ? $svc->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.85</priority>
        @if($svc->image)
        <image:image>
            <image:loc>{{ asset('storage/' . $svc->image) }}</image:loc>
            <image:title>{{ $svc->title }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

    {{-- Proyectos Individuales --}}
    @foreach($projects as $proj)
    <url>
        <loc>{{ route('projects.show', $proj->slug) }}</loc>
        <lastmod>{{ $proj->updated_at ? $proj->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        @if($proj->image)
        <image:image>
            <image:loc>{{ asset('storage/' . $proj->image) }}</image:loc>
            <image:title>{{ $proj->title }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

    {{-- Posts del Blog Individuales --}}
    @foreach($posts as $post)
    <url>
        <loc>{{ route('blog.show', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at ? $post->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.75</priority>
        @if($post->featured_image)
        <image:image>
            <image:loc>{{ asset('storage/' . $post->featured_image) }}</image:loc>
            <image:title>{{ $post->title }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

    {{-- Páginas Legales --}}
    <url>
        <loc>{{ route('legal.privacy') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ route('legal.terms') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ route('legal.cookies') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

</urlset>
