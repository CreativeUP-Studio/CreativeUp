<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('image');
            $table->json('benefits')->nullable()->after('features');
            $table->json('process_steps')->nullable()->after('benefits');
            $table->string('cta_text', 255)->nullable()->after('process_steps');
            $table->string('meta_title', 200)->nullable()->after('cta_text');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
            $table->integer('order')->default(0)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'benefits', 'process_steps', 'cta_text', 'meta_title', 'meta_description', 'order']);
        });
    }
};
