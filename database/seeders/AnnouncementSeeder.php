<?php
namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 announcements
        $announcements = Announcement::factory(20)->create();

        // Link each announcement to 1-3 random categories
        $categories = Category::whereNotNull('parent_id')->get();

        $announcements->each(function ($announcement) use ($categories) {
            $announcement->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
