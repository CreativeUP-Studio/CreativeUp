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
        'menu_img_home',
        'menu_img_services',
        'menu_img_projects',
        'menu_img_blog',
        'menu_img_contact',
    ];

    protected $casts = [
        'show_chat_widget' => 'boolean',
        'show_newsletter' => 'boolean',
    ];

    /**
     * Accessors de URLs de imágenes del menú de navegación (con fallback)
     */
    public function getMenuImgHomeUrlAttribute()
    {
        return $this->menu_img_home ? asset('storage/' . $this->menu_img_home) : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop';
    }

    public function getMenuImgServicesUrlAttribute()
    {
        return $this->menu_img_services ? asset('storage/' . $this->menu_img_services) : 'https://images.unsplash.com/photo-1542744094-3a31f103e35f?q=80&w=800&auto=format&fit=crop';
    }

    public function getMenuImgProjectsUrlAttribute()
    {
        return $this->menu_img_projects ? asset('storage/' . $this->menu_img_projects) : 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?q=80&w=800&auto=format&fit=crop';
    }

    public function getMenuImgBlogUrlAttribute()
    {
        return $this->menu_img_blog ? asset('storage/' . $this->menu_img_blog) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=800&auto=format&fit=crop';
    }

    public function getMenuImgContactUrlAttribute()
    {
        return $this->menu_img_contact ? asset('storage/' . $this->menu_img_contact) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=800&auto=format&fit=crop';
    }

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
            'footer_tagline' => 'El amanecer de una imagen profesional',
            'status_text' => 'Disponible',
            'meta_title' => 'CreativeUp - El amanecer de una imagen profesional',
            'meta_description' => 'El amanecer de una imagen profesional',
            'show_chat_widget' => true,
            'show_newsletter' => true,
        ]);
    }
}
