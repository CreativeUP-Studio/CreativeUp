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
        Schema::table('leads', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('budget');
            $table->string('source', 30)->default('contact')->after('notes');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('source');
            $table->timestamp('read_at')->nullable()->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['notes', 'source', 'priority', 'read_at']);
        });
    }
};
