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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('position')->nullable()->after('avatar'); // Cargo
            $table->string('phone')->nullable()->after('position'); // Teléfono
            $table->text('bio')->nullable()->after('phone'); // Biografía
            $table->string('location')->nullable()->after('bio'); // Ubicación
            $table->string('website')->nullable()->after('location'); // Sitio web
            $table->string('twitter')->nullable()->after('website'); // Twitter
            $table->string('linkedin')->nullable()->after('twitter'); // LinkedIn
            $table->string('github')->nullable()->after('linkedin'); // GitHub
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'position',
                'phone',
                'bio',
                'location',
                'website',
                'twitter',
                'linkedin',
                'github',
            ]);
        });
    }
};
