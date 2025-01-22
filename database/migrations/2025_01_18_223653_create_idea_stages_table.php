<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('idea_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_id')->constrained('ideas')->onDelete('cascade'); // Linked idea
            $table->enum('stage', ['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision']); // Four stages
            $table->boolean('stage_status')->default(false); // Boolean to represent if the stage is completed
            $table->timestamp('changed_at')->nullable(); // Timestamp of stage status update
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_stages');
    }
};
