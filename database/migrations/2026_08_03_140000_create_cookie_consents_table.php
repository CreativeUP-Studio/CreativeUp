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
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('consent_type', 50)->default('all'); // all, essential
            $table->text('user_agent')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->index(['ip_address', 'accepted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
    }
};
