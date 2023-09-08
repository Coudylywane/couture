<?php

use App\Models\Categorie;
use App\Models\Unite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorie_unite', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Categorie::class);
            $table->foreignIdFor(Unite::class);
            $table->integer("etat")->default(0);
            $table->integer("conversion");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_unite');
    }
};