<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CommercialRegistration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'user_type' => 1,
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'is_active' => true,
                'city' => 'Sanaa',
                'address' => 'Hadaa',
                'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',
            ],
            [
                'name' => 'عبدالسلام طنين',
                'email' => 'investor@example.com',
                'user_type' => 2,
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'is_active' => true,
                'city' => 'Sanaa',
                'address' => 'Al-Zubiri',
                'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',
            ],
            [
                'name' => 'اميمة مقراض',
                'email' => 'entrepreneur@example.com',
                'user_type' => 3,
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'is_active' => true,
                'city' => 'Sanaa',
                'address' => 'AL-Dairi',
                'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',
            ],
        ];

        foreach ($users as $user) {
            $createdUser = User::factory()->create($user);

          //  If the user is an investor, create a commercial registration record
            // if ($createdUser->user_type == 2) {
            //     CommercialRegistration::factory()->create([
            //         'user_id' => $createdUser->id,
            //         'registration_number' => 'CR123456', // Example registration number
            //         'status' => 'approved',
            //         'reviewed_at' => now(),
            //     ]);
            // }
        }

        $investors = User::factory(30)->create([
            'user_type' => 2,
            'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',
        ]);

    }
}
