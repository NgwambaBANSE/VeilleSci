<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favoris', function (Blueprint $table) {
            $table->foreignId('article_id')->nullable()->constrained('articles')->nullOnDelete()->after('opportunite_id');
            $table->string('type')->nullable()->after('article_id');
            $table->unique(['user_id', 'article_id']);
        });
    }

    public function down(): void
    {
        Schema::table('favoris', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'article_id']);
            $table->dropForeign(['article_id']);
            $table->dropColumn(['article_id', 'type']);
        });
    }
};