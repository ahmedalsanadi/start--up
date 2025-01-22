<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Announcement;
use App\Models\Idea;
use App\Models\IdeaStage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
            'image' => $this->randomImageUrl(), // Use the randomImageUrl method
            'location' => $this->faker->randomElement($locations),
            'idea_type' => $this->faker->randomElement(['creative', 'traditional']),
            'feasibility_study' => $this->faker->optional()->word . '.pdf',
            'entrepreneur_id' => User::where('user_type', '3')->inRandomOrder()->first()->id,
            'announcement_id' => Announcement::inRandomOrder()->first()->id,
            'approval_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'rejection_reason' => $this->faker->optional()->sentence,
            'is_active' => true,
            'expiry_date' => Carbon::now()->addMonth(), // Set expiry_date to 1 month from today
            'stage' => $this->faker->randomElement(['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision']),
            'created_at' => now(),
        ];
    }

    /**
     * Generate a random image URL using picsum.photos.
     *
     * @return string
     */
    private function randomImageUrl(): string
    {
        $randomSeed = rand(0, 100000);
        return "https://picsum.photos/seed/{$randomSeed}/500/400";
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Idea $idea) {
            // Define the stages in order
            $stages = ['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision'];

            // Find the index of the current stage
            $currentStageIndex = array_search($idea->stage, $stages);

            // Loop through all stages up to the current stage
            for ($i = 0; $i <= $currentStageIndex; $i++) {
                IdeaStage::create([
                    'idea_id' => $idea->id,
                    'stage' => $stages[$i],
                    'stage_status' => true,
                    'changed_at' => Carbon::now()->subDays(($currentStageIndex - $i) * 3), // Incremental dates
                ]);
            }
        });
    }
}
