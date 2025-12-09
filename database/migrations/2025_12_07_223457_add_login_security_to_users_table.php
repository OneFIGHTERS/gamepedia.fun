<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // jumlah gagal login
            $table->unsignedTinyInteger('failed_logins')->default(0);

            // status blokir
            $table->boolean('is_blocked')->default(false);

            // kapan diblokir & siapa yg blok (opsional)
            $table->timestamp('blocked_at')->nullable();
            $table->foreignId('blocked_by')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['blocked_by']);
            $table->dropColumn(['failed_logins', 'is_blocked', 'blocked_at', 'blocked_by']);
        });
    }
};
