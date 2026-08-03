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
            $table->string('menu_img_home')->nullable();
            $table->string('menu_img_services')->nullable();
            $table->string('menu_img_projects')->nullable();
            $table->string('menu_img_blog')->nullable();
            $table->string('menu_img_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'menu_img_home',
                'menu_img_services',
                'menu_img_projects',
                'menu_img_blog',
                'menu_img_contact',
            ]);
        });
    }
};
