<?php
// ── FICHIER 1 : xxxx_create_forum_sujets_table.php ────────
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// ── FICHIER 2 : xxxx_create_forum_reponses_table.php ──────
return new class extends Migration {
    public function up(): void {
        Schema::create('forum_reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sujet_id')->constrained('forum_sujets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('contenu');
            $table->boolean('meilleure_reponse')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('forum_reponses'); }
};