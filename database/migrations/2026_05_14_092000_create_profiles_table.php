<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Infos personnelles
            $table->string('titre')->nullable();           // Dr., Pr., M., Mme
            $table->string('institution')->nullable();
            $table->string('departement')->nullable();
            $table->string('specialite')->nullable();
            $table->string('pays')->default('Burkina Faso');
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->text('biographie')->nullable();
            $table->string('photo')->nullable();

            // CV
            $table->string('cv')->nullable();              // chemin fichier PDF

            // Liens académiques
            $table->string('orcid')->nullable();
            $table->string('researchgate')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('site_web')->nullable();

            // Publications (JSON)
            $table->json('publications')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};