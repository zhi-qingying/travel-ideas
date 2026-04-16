<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('travel_ideas', function (Blueprint $table) {
            $table->id();
            
            // Foreign key: Associated with the users table, and if a user is deleted, the ideas he has posted will also be cascaded and deleted.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_ideas');
    }
};
