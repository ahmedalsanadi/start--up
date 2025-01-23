<?php

namespace Database\Factories;

use App\Models\CommercialRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommercialRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommercialRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::where('user_type', 2)->inRandomOrder()->first()->id,
            'registration_number' => $this->faker->unique()->numerify('CR#####'), // Example: CR12345
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'rejection_reason' => null,
            'reviewed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'reviewed_by' => User::where('user_type', 1)->first()->id,
        ];
    }

    /**
     * Define a state for an approved commercial registration.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'rejection_reason' => null, // No rejection reason for approved registrations
                'reviewed_at' => now(), // Set reviewed_at to the current timestamp
            ];
        });
    }

    /**
     * Define a state for a rejected commercial registration.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
                'rejection_reason' => $this->faker->sentence(), // Add a rejection reason
                'reviewed_at' => now(), // Set reviewed_at to the current timestamp
            ];
        });
    }
}
