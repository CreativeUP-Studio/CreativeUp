<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'challenge', 'solution', 'results',
        'type', 'client', 'year', 'thumbnail',
        'url', 'technologies', 'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'technologies' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function steps()
    {
        return $this->hasMany(ProjectStep::class)->orderBy('order');
    }
}