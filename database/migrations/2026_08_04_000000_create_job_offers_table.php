<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description');
            $table->string('area')->default('Desarrollo');
            $table->string('type')->default('Tiempo completo');
            $table->string('location')->default('Remoto');
            $table->text('requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Insert initial job offers
        DB::table('job_offers')->insert([
            [
                'title'       => 'Diseñador UI/UX Senior',
                'slug'        => 'disenador-ui-ux-senior',
                'description' => 'Buscamos un diseñador con experiencia en Figma, sistemas de diseño y pensamiento centrado en el usuario para liderar proyectos de alto nivel.',
                'area'        => 'Diseño',
                'type'        => 'Tiempo completo',
                'location'    => 'Remoto',
                'is_active'   => true,
                'order'       => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Desarrollador Full Stack',
                'slug'        => 'desarrollador-full-stack',
                'description' => 'Laravel + Vue.js / React. Experiencia mínima de 2 años en proyectos productivos, buenas prácticas y trabajo en equipo.',
                'area'        => 'Desarrollo',
                'type'        => 'Tiempo completo',
                'location'    => 'Remoto',
                'is_active'   => true,
                'order'       => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Especialista en Marketing Digital',
                'slug'        => 'especialista-en-marketing-digital',
                'description' => 'Estrategia de contenido, SEO, SEM y redes sociales. Experiencia en campañas de performance y analítica digital.',
                'area'        => 'Marketing',
                'type'        => 'Medio tiempo',
                'location'    => 'Remoto',
                'is_active'   => true,
                'order'       => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Gestor de Proyectos (PM)',
                'slug'        => 'gestor-de-proyectos-pm',
                'description' => 'Coordinación de equipos creativos y técnicos, gestión de timelines, Scrum/Kanban y comunicación con clientes.',
                'area'        => 'Gestión',
                'type'        => 'Tiempo completo',
                'location'    => 'Remoto',
                'is_active'   => true,
                'order'       => 4,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
