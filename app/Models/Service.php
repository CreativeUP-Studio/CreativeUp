<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'short_description', 'icon', 'image',
        'gallery', 'features', 'benefits', 'process_steps', 'color',
        'cta_text', 'meta_title', 'meta_description', 'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'benefits' => 'array',
            'process_steps' => 'array',
            'gallery' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}