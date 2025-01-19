<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Arabic locations
        $locations = ['الرياض', 'جدة', 'دبي', 'القاهرة', 'عمان', 'بيروت', 'الخرطوم', 'الدار البيضاء', 'تونس', 'الكويت'];

        // Arabic descriptions
        $descriptions = [
            'نبحث عن فكرة مبتكرة في مجال التكنولوجيا لتنفيذها في السوق المحلي.',
            'نريد تطوير منصة تجارة إلكترونية متكاملة لتلبية احتياجات السوق.',
            'نبحث عن شركاء لتنفيذ مشروع زراعي مستدام في منطقة الشرق الأوسط.',
            'نريد تطوير تطبيق جوال لخدمات التوصيل السريع.',
            'نبحث عن فكرة مبتكرة في مجال السياحة لتنفيذها في منطقة الخليج.',
            'نريد إنشاء مركز تدريب مهني متخصص في مجال البرمجة.',
            'نبحث عن فكرة مبتكرة في مجال الصحة لتحسين الخدمات الطبية.',
            'نريد تطوير متجر أزياء إلكتروني لتصميمات مبتكرة.',
            'نبحث عن فكرة مبتكرة في مجال التغذية لتحسين جودة المنتجات.',
            'نريد إنشاء نادي رياضي متكامل في منطقة الرياض.',
        ];

        return [
            'description' => $this->faker->randomElement($descriptions),
            'location' => $this->faker->randomElement($locations),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'budget' => $this->faker->numberBetween(10000, 1000000),
            'investor_id' => User::where('user_type', '2')->inRandomOrder()->first()->id,
            'approval_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'rejection_reason' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => now(),
        ];
    }
}
