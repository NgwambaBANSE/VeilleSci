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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('auteurs')->nullable();
            $table->string('domaine')->nullable();
            $table->string('categorie')->nullable();
            $table->string('doi')->nullable()->unique();
            $table->text('url')->nullable();
            $table->date('date_publication')->nullable();
            $table->string('journal')->nullable();
            $table->longText('resume')->nullable();
            $table->longText('resume_ia')->nullable();
            $table->text('mots_cles')->nullable();
            $table->enum('source', ['crossref', 'pubmed', 'arxiv', 'other'])->default('crossref');
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('domaine');
            $table->index('categorie');
            $table->index('date_publication');
            $table->index('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
