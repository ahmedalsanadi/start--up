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


        Announcement::factory(count: 1)->create([
            'approval_status' => 'approved',
            'status' => 'in-progress',
            'investor_id' =>2,

        ]);
        Announcement::factory(count: 3)->create([
            'approval_status' => 'approved',

        ]);
        Announcement::factory(3)->create([
            'approval_status' => 'pending',

        ]);
        Announcement::factory(3)->create([
            'approval_status' => 'rejected',

        ]);


        $announcements = Announcement::all();

        // Link each announcement to 1-3 random categories
        $categories = Category::all();

        $announcements->each(function ($announcement) use ($categories) {
            $announcement->categories()->attach(
                $categories->random(rand(3, 5))->pluck('id')->toArray()
            );
        });
    }
}
