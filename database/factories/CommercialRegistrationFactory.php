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
        // Randomly assign a status
        $status = $this->faker->randomElement(['pending', 'approved', 'rejected']);

        // If status is pending, reviewed_by and reviewed_at should be null
        if ($status === 'pending') {
            $reviewedBy = null;
            $reviewedAt = null;
        } else {
            // For approved or rejected, assign a reviewer and a review date
            $reviewedBy = User::where('user_type', 1)->inRandomOrder()->first()->id;
            $reviewedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        }

        return [
            'user_id' => User::where('user_type', 2)->inRandomOrder()->first()->id,
            'registration_number' => $this->faker->unique()->numerify('CR#####'), // Example: CR12345
            'status' => $status,
            'rejection_reason' => $status === 'rejected' ? $this->faker->sentence() : null, // Only add rejection reason for rejected status
            'reviewed_at' => $reviewedAt,
            'reviewed_by' => $reviewedBy,
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
                'reviewed_by' => User::where('user_type', 1)->inRandomOrder()->first()->id, // Assign a reviewer
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
                'reviewed_by' => User::where('user_type', 1)->inRandomOrder()->first()->id, // Assign a reviewer
            ];
        });
    }
}
