<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('titre');
        });

        DB::table('articles')->orderBy('id')->chunkById(100, function ($articles) {
            foreach ($articles as $article) {
                $slug = Str::slug($article->titre) ?: 'article-' . $article->id;
                $original = $slug;
                $counter = 1;

                while (DB::table('articles')->where('slug', $slug)->exists()) {
                    $slug = $original . '-' . $counter++;
                }

                DB::table('articles')->where('id', $article->id)->update(['slug' => $slug]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
