<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Review;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_dashboard_returns_ok(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_products_index_returns_ok(): void
    {
        $response = $this->get(route('admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_categories_index_returns_ok(): void
    {
        $response = $this->get(route('admin.categories.index'));
        $response->assertStatus(200);
    }

    public function test_orders_index_returns_ok(): void
    {
        $response = $this->get(route('admin.orders.index'));
        $response->assertStatus(200);
    }

    public function test_customers_index_returns_ok(): void
    {
        $response = $this->get(route('admin.customers.index'));
        $response->assertStatus(200);
    }

    public function test_reviews_index_returns_ok(): void
    {
        $response = $this->get(route('admin.reviews.index'));
        $response->assertStatus(200);
    }

    public function test_newsletter_index_returns_ok(): void
    {
        $response = $this->get(route('admin.newsletter.index'));
        $response->assertStatus(200);
    }

    public function test_settings_index_returns_ok(): void
    {
        $response = $this->get(route('admin.settings.index'));
        $response->assertStatus(200);
    }

    public function test_content_sections_returns_ok(): void
    {
        $response = $this->get(route('admin.content.sections'));
        $response->assertStatus(200);
    }

    public function test_content_faqs_returns_ok(): void
    {
        $response = $this->get(route('admin.content.faqs'));
        $response->assertStatus(200);
    }

    public function test_product_create_page_returns_ok(): void
    {
        Category::factory()->count(3)->create();
        $response = $this->get(route('admin.products.create'));
        $response->assertStatus(200);
    }

    public function test_category_create_page_returns_ok(): void
    {
        $response = $this->get(route('admin.categories.create'));
        $response->assertStatus(200);
    }

    public function test_category_edit_page_returns_ok(): void
    {
        $category = Category::factory()->create();
        $response = $this->get(route('admin.categories.edit', $category));
        $response->assertStatus(200);
    }

    public function test_order_detail_page_returns_ok(): void
    {
        $order = Order::factory()->pending()->create([
            'customer_email' => 'test@example.com',
        ]);

        $response = $this->get(route('admin.orders.show', $order));
        $response->assertStatus(200);
    }

    public function test_order_status_update(): void
    {
        $order = Order::factory()->pending()->create([
            'customer_email' => 'test@example.com',
        ]);

        $response = $this->put(route('admin.orders.status', $order), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
    }
}
