<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => ucfirst($name),
            'slug' => str($name)->slug(),
            'description' => $this->faker->sentence(8),
            'icon' => $this->faker->randomElement(['⚔️', '🗡️', '🔪', '🏆', '📦', '🛡️', '🏹']),
            'sort_order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
