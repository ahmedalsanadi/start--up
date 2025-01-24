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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the idea
            $table->text('brief_description'); // Brief description of the idea
            $table->text('detailed_description'); // Detailed description of the idea
            $table->decimal('budget', 10, 2); // Required budget for the idea
            $table->string('image')->nullable(); // Image of the idea
            $table->string('location'); // Location of the idea
            $table->enum('idea_type', ['creative', 'traditional']); // Type of idea
            $table->string('feasibility_study')->nullable(); // Feasibility study file (PDF)
            $table->foreignId('entrepreneur_id')->constrained('users')->onDelete('cascade'); // Entrepreneur who created the idea
            $table->foreignId('announcement_id')->nullable()->constrained('announcements')->onDelete('cascade'); // Linked announcement (for creative ideas)
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // Approval status by admin
            $table->text('rejection_reason')->nullable(); // Reason for rejection
            $table->enum('status', ['in-progress', 'approved', 'rejected', 'deleted_by_entrepreneur','expired'])->default('in-progress'); // Status of the idea

            $table->date('expiry_date')->nullable(); // Expiry date for creative ideas (1 month)
            $table->enum('stage', ['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision'])->default('new'); // Stage of the idea
            $table->boolean('is_reusable')->default(false); // Whether the idea is reusable
            $table->softDeletes(); // Add deleted_at column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        // Drop the soft deletes column (deleted_at)
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Remove deleted_at column
        });

        // Drop the entire table
        Schema::dropIfExists('ideas');
    }
};
