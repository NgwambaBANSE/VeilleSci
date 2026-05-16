<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ── Migration 2 : php artisan make:migration create_forum_replies_table ──

return new class extends Migration {
    public function up(): void {
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('forum_topic_id')->constrained()->onDelete('cascade');
            $table->text('contenu');
            $table->boolean('meilleure_reponse')->default(false);
            $table->unsignedInteger('votes')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('forum_replies'); }
};