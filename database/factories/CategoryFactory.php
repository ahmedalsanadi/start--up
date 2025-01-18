<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'parent_id' => null, // Default as parent category
        ];
    }

    // State to generate subcategories
    public function subCategory($parentId)
    {
        return $this->state([
            'parent_id' => $parentId,
        ]);
    }
}
