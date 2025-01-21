<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Idea;
use App\Models\Category;
use App\Models\IdeaStage;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all announcements
        $announcements = Announcement::all();

        // Create 5 ideas for each announcement
        $announcements->each(function ($announcement) {
            Idea::factory(5)->create([
                'announcement_id' => $announcement->id,
            ])->each(function ($idea) {
                // Link each idea to 1-3 random categories
                $categories = Category::whereNotNull('parent_id')->inRandomOrder()->limit(rand(1, 3))->get();
                $idea->categories()->attach($categories);

                // Create stages for the idea
                $stages = ['initial_approve', 'under_review', 'last_decision'];
                $changedAt = Carbon::now();

                foreach ($stages as $stage) {
                    IdeaStage::create([
                        'idea_id' => $idea->id,
                        'stage' => $stage,
                        'changed_at' => $changedAt,
                    ]);

                    // Increment the timestamp for the next stage
                    $changedAt = $changedAt->addDays(rand(1, 3)); // Add 1-3 days between stages
                }
            });
        });
    }
}
