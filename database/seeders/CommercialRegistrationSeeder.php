<?php

namespace Database\Seeders;

use App\Models\CommercialRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommercialRegistrationSeeder extends Seeder
{
    public function run()
    {
        // Get all investors (users with user_type = 2)
        $investors = User::where('user_type', 2)->get();

        // Check if there are any investors
        if ($investors->isEmpty()) {
            $this->command->info('No investors found. Please create some investors first.');
            return;
        }

        // Create one commercial registration for each investor
        foreach ($investors as $investor) {
            CommercialRegistration::factory()->create([
                'user_id' => $investor->id,
            ]);
        }

        // $this->command->info('Successfully created one commercial registration for each investor.');
    }
}
