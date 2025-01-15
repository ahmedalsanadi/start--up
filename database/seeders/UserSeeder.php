<?php

namespace Database\Seeders;

use App\Models\User;
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
                'is_pending' => false,
                'city' => 'Sanaa',
                'address' => 'Hadaa',
                'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',

            ],
            [
                'name' => 'investor',
                'email' => 'investor@example.com',
                'user_type' => 2,
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'is_pending' => false,
                'city' => 'Sanaa',
                'address' => 'Al-Zubiri',
                'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',

            ],
            [
                'name' => 'entrepreneur',
                'email' => 'entrepreneur@example.com',
                'user_type' => 3,
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'is_pending' => false,
                'city' => 'Sanaa',
                'address' => 'AL-Dairi',
                'profile_image' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80',

            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
        User::factory(1)->create(
            [
                'user_type' => 1
            ]
        );
    }
}
