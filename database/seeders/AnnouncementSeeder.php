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
        $announcements = Announcement::factory(30)->create();

        // Link each announcement to 1-3 random categories
        $categories = Category::all();

        $announcements->each(function ($announcement) use ($categories) {
            $announcement->categories()->attach(
                $categories->random(rand(3, 5))->pluck('id')->toArray()
            );
        });
    }
}
