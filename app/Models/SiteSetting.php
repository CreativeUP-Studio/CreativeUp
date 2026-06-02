<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'address',
        'maps_url',
        'whatsapp_url',
        'timezone',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'github_url',
        'logo_text',
        'logo_gradient_text',
        'footer_tagline',
        'status_text',
        'meta_title',
        'meta_description',
        'show_chat_widget',
        'show_newsletter',
    ];

    protected $casts = [
        'show_chat_widget' => 'boolean',
        'show_newsletter' => 'boolean',
    ];

    /**
     * Obtener la configuración del sitio (el primer registro, o uno por defecto)
     */
    public static function getSettings()
    {
        return self::first() ?? self::getDefault();
    }

    /**
     * Obtener la configuración por defecto
     */
    public static function getDefault()
    {
        return new self([
            'phone' => '+51 999 999 999',
            'email' => 'hola@creativeup.com',
            'address' => 'Gran Vía, 12, 28013 Madrid, España',
            'maps_url' => 'https://maps.google.com',
            'whatsapp_url' => 'https://wa.me/34123456789',
            'timezone' => 'America/Lima',
            'facebook_url' => '#',
            'instagram_url' => '#',
            'linkedin_url' => '#',
            'twitter_url' => '#',
            'github_url' => '#',
            'logo_text' => 'creative',
            'logo_gradient_text' => 'up',
            'footer_tagline' => 'Diseñamos y desarrollamos soluciones digitales innovadoras que impulsan el crecimiento empresarial.',
            'status_text' => 'Disponible',
            'meta_title' => 'CreativeUp - Agencia Digital Innovadora',
            'meta_description' => 'Transformamos ideas en experiencias digitales extraordinarias',
            'show_chat_widget' => true,
            'show_newsletter' => true,
        ]);
    }
}
