<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Idea;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all approved announcements
        $announcements = Announcement::where('approval_status', 'approved')->get();

        // Create 6 creative ideas for each announcement
        $announcements->each(function ($announcement) {
            Idea::factory(6)->create([
                'announcement_id' => $announcement->id,
                'approval_status' => 'approved',
                'status' => 'in-progress',
                'is_reusable' => false,
                'idea_type' => 'creative',
                'expiry_date' => Carbon::now()->addMonth(),
            ]);
        });

        // Create 6 traditional ideas
        Idea::factory(20)->create([
            'approval_status' => 'approved',
            'status' => 'in-progress',
            'is_reusable' => true,
            'idea_type' => 'traditional',
            'expiry_date' => Carbon::now()->addMonth(),
        ]);
    }
}
