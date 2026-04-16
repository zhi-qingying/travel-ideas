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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            
            // Who posted the comment
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // On which travel idea the comment is posted
            $table->foreignId('travel_idea_id')->constrained()->onDelete('cascade');
            
            // Comment content, strictly limited to a maximum length of 255 characters
            $table->string('content', 255); 
            
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
