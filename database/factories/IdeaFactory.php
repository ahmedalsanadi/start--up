<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Arabic names and descriptions
        $names = [
            'تطبيق توصيل طعام',
            'منصة تعليمية عبر الإنترنت',
            'مشروع زراعي مستدام',
            'نادي رياضي متكامل',
            'تطبيق إدارة المشاريع',
        ];

        $briefDescriptions = [
            'تطبيق جوال لتوصيل الطعام من المطاعم إلى العملاء.',
            'منصة تعليمية تقدم دورات في البرمجة والتصميم.',
            'مشروع زراعي يعتمد على تقنيات الري الحديثة.',
            'نادي رياضي يوفر مرافق متكاملة للرياضة واللياقة البدنية.',
            'تطبيق جوال لإدارة المهام والمشاريع للفرق الصغيرة.',
        ];

        $detailedDescriptions = [
            'تطبيق يسمح للمستخدمين بطلب الطعام من المطاعم المحلية ويوفر خدمة توصيل سريعة.',
            'منصة تقدم دورات تعليمية في مجالات التكنولوجيا والتصميم مع شهادات معتمدة.',
            'مشروع يهدف إلى زيادة الإنتاج الزراعي باستخدام تقنيات الري الحديثة والزراعة المستدامة.',
            'نادي رياضي يضم صالات رياضية وحمامات سباحة ومرافق ترفيهية.',
            'تطبيق يسمح للفرق بإدارة المهام والمشاريع بشكل فعال مع ميزات مثل المهام المشتركة والتذكيرات.',
        ];

        $locations = ['الرياض', 'جدة', 'دبي', 'القاهرة', 'عمان'];

        return [
            'name' => $this->faker->randomElement($names),
            'brief_description' => $this->faker->randomElement($briefDescriptions),
            'detailed_description' => $this->faker->randomElement($detailedDescriptions),
            'budget' => $this->faker->numberBetween(100000, 2000000),
            'image' => $this->faker->optional()->imageUrl(),
            'location' => $this->faker->randomElement($locations),
            'idea_type' => $this->faker->randomElement(['creative', 'traditional']),
            'feasibility_study' => $this->faker->optional()->word . '.pdf',
            'entrepreneur_id' => User::where('user_type', '3')->inRandomOrder()->first()->id,
            'announcement_id' => Announcement::inRandomOrder()->first()->id,
            'approval_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'rejection_reason' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'expiry_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'created_at' => now(),
        ];
    }
}
