<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPageTest extends TestCase
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
            'is_featured' => true,
            'stock' => 5,
        ]);
    }

    public function test_shop_page_returns_ok(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
    }

    public function test_shop_page_shows_products(): void
    {
        $product = $this->createProduct();
        $response = $this->get('/shop');
        $response->assertSee($product->name);
    }

    public function test_product_detail_page_returns_ok(): void
    {
        $product = $this->createProduct();
        $response = $this->get("/shop/{$product->slug}");
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_product_detail_shows_price(): void
    {
        $product = $this->createProduct();
        $response = $this->get("/shop/{$product->slug}");
        $response->assertSee($product->formatted_price);
    }

    public function test_category_page_returns_ok(): void
    {
        $category = Category::factory()->create(['is_active' => true, 'slug' => 'katanas']);
        $response = $this->get("/category/{$category->slug}");
        $response->assertStatus(200);
    }

    public function test_product_404_for_nonexistent(): void
    {
        $response = $this->get('/shop/nonexistent-product');
        $response->assertStatus(404);
    }
}
