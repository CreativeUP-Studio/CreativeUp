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
        // Índices para la tabla services
        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'order'], 'services_active_order_index');
        });

        // Índices para la tabla projects
        Schema::table('projects', function (Blueprint $table) {
            $table->index(['status', 'published_at'], 'projects_status_published_index');
        });

        // Índices para la tabla posts
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'published_at'], 'posts_status_published_index');
        });

        // Índice para la tabla project_images
        Schema::table('project_images', function (Blueprint $table) {
            $table->index('project_id', 'project_images_project_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('services_active_order_index');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('projects_status_published_index');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_status_published_index');
        });

        Schema::table('project_images', function (Blueprint $table) {
            $table->dropIndex('project_images_project_id_index');
        });
    }
};
