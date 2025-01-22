<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Idea;
use App\Models\Category;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all approved announcements
        $announcements = Announcement::where('approval_status', 'approved')->get();

        // Create 5 ideas for each announcement
        $announcements->each(function ($announcement) {
            Idea::factory(5)->create([
                'announcement_id' => $announcement->id,
            ])->each(function ($idea) {
                // Link each idea to 3-5 random categories
                $categories = Category::inRandomOrder()->limit(rand(3, 5))->get();
                $idea->categories()->attach($categories);
            });
        });
    }
}
