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
        Schema::table('cookie_consents', function (Blueprint $table) {
            $table->string('hardware_fingerprint', 100)->nullable()->after('ip_address');
            $table->string('cpu_cores', 50)->nullable()->after('os');
            $table->string('device_memory', 50)->nullable()->after('cpu_cores');
            $table->string('connection_type', 50)->nullable()->after('device_memory');
            $table->string('touch_points', 50)->nullable()->after('connection_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cookie_consents', function (Blueprint $table) {
            $table->dropColumn([
                'hardware_fingerprint',
                'cpu_cores',
                'device_memory',
                'connection_type',
                'touch_points'
            ]);
        });
    }
};
