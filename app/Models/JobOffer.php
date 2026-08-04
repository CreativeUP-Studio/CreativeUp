<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobOffer extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'area',
        'type',
        'location',
        'requirements',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($job) {
            if (empty($job->slug) && !empty($job->title)) {
                $job->slug = Str::slug($job->title);
            }
        });
    }
}
