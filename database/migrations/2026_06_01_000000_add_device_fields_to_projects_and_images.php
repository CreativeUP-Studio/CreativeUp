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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('thumbnail_device')->default('macbook')->nullable()->after('thumbnail');
        });

        Schema::table('project_images', function (Blueprint $table) {
            $table->string('device_type')->default('none')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('thumbnail_device');
        });

        Schema::table('project_images', function (Blueprint $table) {
            $table->dropColumn('device_type');
        });
    }
};
