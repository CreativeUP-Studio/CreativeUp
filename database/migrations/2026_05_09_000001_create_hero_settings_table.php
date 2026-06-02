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
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            
            // Badge
            $table->string('badge_text')->default('Agencia Digital Innovadora');
            $table->boolean('badge_show_dot')->default(true);
            $table->boolean('badge_show_sparkle')->default(true);
            
            // Título
            $table->string('title_line_1')->default('Diseñamos el');
            $table->string('title_gradient_word')->default('Futuro');
            $table->string('title_outline_word')->default('Digital');
            
            // Palabras rotativas para el efecto typing
            $table->json('rotating_words')->nullable(); // ["Futuro", "Éxito", "Diseño", "Negocio"]
            
            // Subtítulo
            $table->text('subtitle')->nullable();
            
            // Botones CTA
            $table->string('primary_button_text')->default('Iniciar Proyecto');
            $table->string('primary_button_url')->default('/contacto');
            $table->boolean('primary_button_active')->default(true);
            
            $table->string('secondary_button_text')->default('Ver Reel');
            $table->string('secondary_button_url')->default('#portfolio');
            $table->boolean('secondary_button_active')->default(true);
            
            // Imagen/Mockup
            $table->string('mockup_image')->nullable();
            $table->integer('featured_project_id')->nullable();
            
            // Social Proof
            $table->boolean('show_social_proof')->default(true);
            $table->string('social_proof_text')->default('Clientes globales satisfechos');
            $table->integer('social_proof_count')->default(500);
            
            // Floating Cards
            $table->boolean('show_float_card_1')->default(true);
            $table->string('float_card_1_icon')->default('fa-rocket');
            $table->string('float_card_1_title')->default('Performance');
            $table->string('float_card_1_value')->default('99.9% Score');
            
            $table->boolean('show_float_card_2')->default(true);
            $table->string('float_card_2_icon')->default('fa-chart-line');
            $table->string('float_card_2_title')->default('Conversión');
            $table->string('float_card_2_value')->default('+150% ROI');
            
            // Scroll Indicator
            $table->boolean('show_scroll_indicator')->default(true);
            
            // Estado
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
