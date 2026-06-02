<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->string('conversation_id', 50)->after('id')->index();
            $table->enum('sender', ['user', 'admin'])->default('user')->after('message');
            $table->boolean('is_read')->default(false)->after('sender');
            
            // Eliminar campos que ya no necesitamos
            $table->dropColumn(['admin_reply', 'replied_at']);
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn(['conversation_id', 'sender', 'is_read']);
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
        });
    }
};
