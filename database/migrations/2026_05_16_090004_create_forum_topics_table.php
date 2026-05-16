<?php
// ── Migration 1 : php artisan make:migration create_forum_topics_table ──

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('contenu');
            $table->enum('categorie', [
                'Bourses', 'Publications', 'Conférences',
                'Formations', 'Stages', 'Général', 'Méthodologie'
            ])->default('Général');
            $table->boolean('resolu')->default(false);
            $table->unsignedInteger('vues')->default(0);
            $table->boolean('epingle')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('forum_topics'); }
};