<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Tambah STATUS kalau belum ada
            if (! Schema::hasColumn('articles', 'status')) {
                $table->string('status')
                    ->default('pending')
                    ->after('content');
            }

            // Tambah PUBLISHED_BY kalau belum ada
            if (! Schema::hasColumn('articles', 'published_by')) {
                $table->foreignId('published_by')
                    ->nullable()
                    ->after('status')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            // Tambah PUBLISHED_AT kalau belum ada
            if (! Schema::hasColumn('articles', 'published_at')) {
                $table->timestamp('published_at')
                    ->nullable()
                    ->after('published_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'published_at')) {
                $table->dropColumn('published_at');
            }

            if (Schema::hasColumn('articles', 'published_by')) {
                $table->dropConstrainedForeignId('published_by');
            }

            if (Schema::hasColumn('articles', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
