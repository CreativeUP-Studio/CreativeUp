<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'content',
        'featured_image', 'category', 'status', 'published_at', 'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 120);
    }

    public function getReadTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    public function getCategoryLabelAttribute(): string
    {
        $map = [
            'branding' => 'Branding',
            'diseno'   => 'Diseño Web',
            'seo'      => 'SEO & Analytics',
            'redes'    => 'Social Media',
            'marketing' => 'Marketing Digital',
        ];

        // Prioridad: valor guardado en BD
        if ($this->category && isset($map[$this->category])) {
            return $map[$this->category];
        }

        // Fallback: inferir desde slug
        foreach ($map as $key => $label) {
            if (str_contains(strtolower($this->slug), $key)) {
                return $label;
            }
        }

        return 'Marketing Digital';
    }

    public function getCategoryGradientAttribute(): string
    {
        $map = [
            'branding'  => 'linear-gradient(135deg,#ff006e 0%,#8338ec 100%)',
            'diseno'    => 'linear-gradient(135deg,#8338ec 0%,#3a0ca3 100%)',
            'seo'       => 'linear-gradient(135deg,#00b4d8 0%,#0077b6 100%)',
            'redes'     => 'linear-gradient(135deg,#f59e0b 0%,#ef4444 100%)',
            'marketing' => 'linear-gradient(135deg,#06d6a0 0%,#118ab2 100%)',
        ];

        return $map[$this->category ?? 'marketing'] ?? 'linear-gradient(135deg,#ff006e 0%,#8338ec 100%)';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
