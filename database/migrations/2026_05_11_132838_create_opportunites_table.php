<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunites', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('categorie', ['Publications', 'Conférences', 'Formations', 'Stages', 'Bourses']);
            $table->string('domaine');
            $table->date('date_limite');
            $table->string('pays');
            $table->text('description');
            $table->string('lien')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunites');
    }
};