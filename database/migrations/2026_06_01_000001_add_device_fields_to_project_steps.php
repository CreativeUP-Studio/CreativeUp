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
        Schema::table('project_steps', function (Blueprint $table) {
            $table->string('image1_device')->default('safari')->nullable()->after('image1');
            $table->string('image2_device')->default('iphone')->nullable()->after('image2');
            $table->string('image3_device')->default('ipad')->nullable()->after('image3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_steps', function (Blueprint $table) {
            $table->dropColumn(['image1_device', 'image2_device', 'image3_device']);
        });
    }
};
