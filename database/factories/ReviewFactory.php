<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\Product;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_country' => $this->faker->country(),
            'rating' => $this->faker->numberBetween(3, 5),
            'title' => $this->faker->sentence(4),
            'body' => $this->faker->paragraph(2),
            'is_verified' => $this->faker->boolean(70),
            'is_approved' => $this->faker->boolean(80),
            'is_featured' => $this->faker->boolean(15),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => ['is_approved' => true]);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true, 'is_approved' => true]);
    }

    public function pending(): static
    {
        return $this->state(fn () => ['is_approved' => false]);
    }
}
