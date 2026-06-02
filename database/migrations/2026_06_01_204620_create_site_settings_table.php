<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            
            // Información de Contacto
            $table->string('phone')->default('+51 999 999 999');
            $table->string('email')->default('hola@creativeup.com');
            $table->string('address')->default('Gran Vía, 12, 28013 Madrid, España');
            $table->string('maps_url')->default('https://maps.google.com');
            $table->string('whatsapp_url')->default('https://wa.me/34123456789');
            $table->string('timezone')->default('America/Lima');
            
            // Redes Sociales
            $table->string('facebook_url')->nullable()->default('#');
            $table->string('instagram_url')->nullable()->default('#');
            $table->string('linkedin_url')->nullable()->default('#');
            $table->string('twitter_url')->nullable()->default('#');
            $table->string('github_url')->nullable()->default('#');
            
            // Branding & Textos Generales
            $table->string('logo_text')->default('creative');
            $table->string('logo_gradient_text')->default('up');
            $table->string('footer_tagline')->default('Diseñamos y desarrollamos soluciones digitales innovadoras que impulsan el crecimiento empresarial.');
            $table->string('status_text')->default('Disponible');
            
            // SEO General
            $table->string('meta_title')->default('CreativeUp - Agencia Digital Innovadora');
            $table->string('meta_description')->default('Transformamos ideas en experiencias digitales extraordinarias');
            
            // Opciones y Funcionalidades
            $table->boolean('show_chat_widget')->default(true);
            $table->boolean('show_newsletter')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
