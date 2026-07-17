<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_has_reference_number(): void
    {
        $order = Order::factory()->pending()->create();
        $this->assertNotEmpty($order->reference_number);
        $this->assertStringStartsWith('YO-', $order->reference_number);
    }

    public function test_reference_number_is_unique(): void
    {
        $order1 = Order::factory()->pending()->create();
        $order2 = Order::factory()->pending()->create();
        $this->assertNotEquals($order1->reference_number, $order2->reference_number);
    }

    public function test_order_has_many_items(): void
    {
        $order = Order::factory()->pending()->create();
        OrderItem::factory()->count(3)->create(['order_id' => $order->id]);

        $this->assertCount(3, $order->items);
    }

    public function test_order_has_correct_statuses(): void
    {
        $statuses = ['pending', 'confirmed', 'processing', 'delivered', 'cancelled'];

        foreach ($statuses as $status) {
            $order = Order::factory()->$status()->create();
            $this->assertEquals($status, $order->status);
        }
    }

    public function test_pending_scope_filters(): void
    {
        Order::factory()->pending()->count(3)->create();
        Order::factory()->confirmed()->count(2)->create();

        $this->assertCount(3, Order::pending()->get());
    }

    public function test_order_default_status_is_pending(): void
    {
        $order = Order::factory()->pending()->create();
        $this->assertEquals('pending', $order->status);
    }

    public function test_order_casts_dates(): void
    {
        $order = Order::factory()->pending()->create();

        $this->assertNotNull($order->created_at);
        $this->assertNotNull($order->updated_at);
    }

    public function test_order_fillable_fields(): void
    {
        $order = new Order();
        $fillable = $order->getFillable();

        $this->assertContains('customer_name', $fillable);
        $this->assertContains('customer_email', $fillable);
        $this->assertContains('status', $fillable);
        $this->assertContains('customer_address', $fillable);
    }
}
