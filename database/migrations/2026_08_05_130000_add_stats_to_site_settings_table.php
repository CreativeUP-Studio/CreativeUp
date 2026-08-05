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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('stat_projects_count')->nullable()->default('250');
            $table->string('stat_projects_label')->nullable()->default('Proyectos Lanzados');

            $table->string('stat_clients_count')->nullable()->default('99');
            $table->string('stat_clients_suffix')->nullable()->default('%');
            $table->string('stat_clients_label')->nullable()->default('Clientes Satisfechos');

            $table->string('stat_awards_count')->nullable()->default('15');
            $table->string('stat_awards_suffix')->nullable()->default('+');
            $table->string('stat_awards_label')->nullable()->default('Premios de Diseño');

            $table->string('stat_years_count')->nullable()->default('10');
            $table->string('stat_years_suffix')->nullable()->default('Años');
            $table->string('stat_years_label')->nullable()->default('De Experiencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'stat_projects_count', 'stat_projects_label',
                'stat_clients_count', 'stat_clients_suffix', 'stat_clients_label',
                'stat_awards_count', 'stat_awards_suffix', 'stat_awards_label',
                'stat_years_count', 'stat_years_suffix', 'stat_years_label',
            ]);
        });
    }
};
