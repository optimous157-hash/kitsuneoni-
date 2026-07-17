<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class OrderPageTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(): Product
    {
        $category = Category::factory()->create(['is_active' => true]);
        $brand = Brand::factory()->create(['is_active' => true]);

        return Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
            'stock' => 10,
        ]);
    }

    public function test_order_page_returns_ok(): void
    {
        $product = $this->createProduct();
        $response = $this->get("/order?product_id={$product->id}");
        $response->assertStatus(200);
    }

    public function test_order_submission_creates_order(): void
    {
        Mail::fake();
        $product = $this->createProduct();

        $response = $this->post('/order', [
            'product_id' => $product->id,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '+1234567890',
            'customer_address' => '123 Test Street',
            'customer_city' => 'Test City',
            'customer_country' => 'US',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'customer_email' => 'john@example.com',
            'customer_name' => 'John Doe',
        ]);
    }

    public function test_order_submission_sends_emails(): void
    {
        Mail::fake();
        $product = $this->createProduct();

        $this->post('/order', [
            'product_id' => $product->id,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '+1234567890',
            'customer_address' => '123 Test Street',
            'customer_city' => 'Test City',
            'customer_country' => 'US',
        ]);

        Mail::assertSent(\App\Mail\OrderConfirmationMail::class, function ($mail) {
            return $mail->hasTo('john@example.com');
        });
    }

    public function test_order_submission_validates_required_fields(): void
    {
        $response = $this->post('/order', []);
        $response->assertSessionHasErrors([
            'product_id', 'quantity', 'customer_name', 'customer_email',
            'customer_address', 'customer_city', 'customer_country',
        ]);
    }

    public function test_order_success_page_returns_ok(): void
    {
        $product = $this->createProduct();
        $order = Order::create([
            'reference_number' => 'YO-TEST1234',
            'customer_name' => 'Test User',
            'customer_email' => 'test@example.com',
            'customer_country' => 'US',
            'customer_city' => 'Test City',
            'customer_address' => '123 Test St',
            'subtotal' => 100,
            'shipping_cost' => 25,
            'total' => 125,
            'status' => 'pending',
        ]);
        $response = $this->get("/order/{$order->reference_number}/success");
        $response->assertStatus(200);
    }
}
