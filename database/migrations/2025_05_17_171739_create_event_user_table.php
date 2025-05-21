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
       Schema::create('event_user', function (Blueprint $table) { // taula pivot entre usuaris i esdeveniments (n-n)
            $table->id(); 
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete(); // Clau forana que relaciona amb la taula events
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();  // Clau forana que relaciona amb la taula users
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user');
    }
};
