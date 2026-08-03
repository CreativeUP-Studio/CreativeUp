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
            $table->string('device_type', 50)->nullable()->after('consent_type');
            $table->string('browser', 100)->nullable()->after('device_type');
            $table->string('os', 100)->nullable()->after('browser');
            $table->string('screen_resolution', 50)->nullable()->after('os');
            $table->string('language', 50)->nullable()->after('screen_resolution');
            $table->string('page_url', 255)->nullable()->after('language');
            $table->string('timezone', 100)->nullable()->after('page_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cookie_consents', function (Blueprint $table) {
            $table->dropColumn([
                'device_type',
                'browser',
                'os',
                'screen_resolution',
                'language',
                'page_url',
                'timezone'
            ]);
        });
    }
};
