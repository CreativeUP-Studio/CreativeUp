<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'website_url',
        'industry',
        'testimonial',
        'order',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'order'       => 'integer',
    ];

    /**
     * Scope para filtrar solo los clientes activos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para filtrar los clientes destacados.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para ordenar clientes.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * URL completa del logo.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
                return $this->logo;
            }
            return Storage::url($this->logo);
        }
        return null;
    }

    /**
     * Iniciales del cliente para avatares cuando no hay logo.
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', trim($this->name));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }
}
