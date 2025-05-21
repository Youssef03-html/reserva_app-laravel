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
        Schema::create('events', function (Blueprint $table) { // taula nova d'esdeveniments amb els seus camps
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->integer('max_attendees');
            $table->integer('min_age');
            $table->string('image')->nullable(); // Ruta de la imatge o nom (opcinonal).
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete(); // clau forana, event / categoria
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
