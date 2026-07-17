<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = $this->faker->numberBetween(25, 350);
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => str(ucfirst($name))->slug(),
            'short_description' => $this->faker->sentence(15),
            'description' => '<p>' . $this->faker->paragraphs(3, true) . '</p>',
            'price' => $price,
            'compare_at_price' => $this->faker->optional(0.4, null)->numberBetween($price + 20, $price + 100),
            'sku' => 'YO-' . strtoupper($this->faker->bothify('???-####')),
            'stock' => $this->faker->numberBetween(0, 50),
            'is_featured' => $this->faker->boolean(20),
            'is_bestseller' => $this->faker->boolean(15),
            'is_new' => $this->faker->boolean(25),
            'is_active' => true,
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'material' => $this->faker->randomElement(['Carbon Steel', 'Damascus Steel', 'Stainless Steel', 'Wood', 'Leather', 'Resin']),
            'overall_length' => $this->faker->optional(0.8, null)->numberBetween(25, 115),
            'blade_length' => $this->faker->optional(0.8, null)->numberBetween(15, 75),
            'weight' => $this->faker->optional(0.8, null)->numberBetween(150, 1200),
            'meta_title' => null,
            'meta_description' => null,
            'sales_count' => $this->faker->numberBetween(0, 200),
            'views_count' => $this->faker->numberBetween(0, 5000),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function bestseller(): static
    {
        return $this->state(fn () => ['is_bestseller' => true, 'sales_count' => $this->faker->numberBetween(30, 200)]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }

    public function active(): static
    {
        return $this->state(fn () => ['is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
