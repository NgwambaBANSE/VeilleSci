<?php
// ── FICHIER 1 : xxxx_create_forum_sujets_table.php ────────
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('forum_sujets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('contenu');
            $table->enum('categorie', [
                'Bourses', 'Publications', 'Conférences',
                'Formations', 'Stages', 'Méthodologie',
                'Carrière', 'Autre'
            ])->default('Autre');
            $table->boolean('resolu')->default(false);
            $table->integer('vues')->default(0);
            $table->boolean('epingle')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('forum_sujets'); }
};

