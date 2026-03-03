<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'content',
        'featured_image', 'status', 'published_at'
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
            'diseno' => 'Diseño Web',
            'seo' => 'SEO',
            'redes' => 'Social Media',
        ];

        foreach ($map as $key => $label) {
            if (str_contains(strtolower($this->slug), $key)) {
                return $label;
            }
        }

        return 'Marketing';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
