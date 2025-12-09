<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // status artikel: pending / published / rejected (opsional)
            if (!Schema::hasColumn('articles', 'status')) {
                $table->string('status')->default('pending')->after('content');
            }

            // siapa admin/super_admin yang mem-publish
            if (!Schema::hasColumn('articles', 'published_by')) {
                $table->unsignedBigInteger('published_by')->nullable()->after('status');
            }

            // kapan di-publish
            if (!Schema::hasColumn('articles', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('published_by');
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
                $table->dropColumn('published_by');
            }
            if (Schema::hasColumn('articles', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
