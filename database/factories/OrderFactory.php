<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = $this->faker->numberBetween(25, 600);
        $shipping = $this->faker->numberBetween(0, 50);

        return [
            'reference_number' => 'YO-' . strtoupper($this->faker->bothify('???-#####')),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'processing', 'delivered', 'cancelled']),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_country' => $this->faker->country(),
            'customer_city' => $this->faker->city(),
            'customer_address' => $this->faker->streetAddress(),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total' => $subtotal + $shipping,
            'currency' => 'USD',
            'notes' => $this->faker->optional(0.4)->sentence(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function confirmed(): static
    {
        return $this->state(fn () => ['status' => 'confirmed', 'confirmed_at' => now()]);
    }

    public function processing(): static
    {
        return $this->state(fn () => ['status' => 'processing', 'processing_at' => now()]);
    }

    public function delivered(): static
    {
        return $this->state(fn () => ['status' => 'delivered', 'delivered_at' => now()]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => ['status' => 'cancelled', 'cancelled_at' => now()]);
    }
}
