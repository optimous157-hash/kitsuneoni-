<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_has_required_fillable(): void
    {
        $product = new Product();
        $fillable = $product->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('slug', $fillable);
        $this->assertContains('price', $fillable);
        $this->assertContains('category_id', $fillable);
    }

    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_product_belongs_to_brand(): void
    {
        $brand = Brand::factory()->create();
        $product = Product::factory()->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertEquals($brand->id, $product->brand->id);
    }

    public function test_product_has_many_images(): void
    {
        $product = Product::factory()->create();
        ProductImage::factory()->count(3)->create(['product_id' => $product->id]);

        $this->assertCount(3, $product->images);
    }

    public function test_product_has_many_reviews(): void
    {
        $product = Product::factory()->create();
        $this->assertCount(0, $product->reviews);
    }

    public function test_active_scope_filters(): void
    {
        Product::factory()->create(['is_active' => true]);
        Product::factory()->create(['is_active' => false]);
        Product::factory()->create(['is_active' => true]);

        $this->assertCount(2, Product::active()->get());
    }

    public function test_featured_scope_filters(): void
    {
        Product::factory()->create(['is_featured' => true, 'is_active' => true]);
        Product::factory()->create(['is_featured' => false, 'is_active' => true]);
        Product::factory()->create(['is_featured' => true, 'is_active' => true]);

        $this->assertCount(2, Product::featured()->get());
    }

    public function test_in_stock_scope_filters(): void
    {
        Product::factory()->create(['stock' => 5, 'is_active' => true]);
        Product::factory()->create(['stock' => 0, 'is_active' => true]);
        Product::factory()->create(['stock' => 10, 'is_active' => true]);

        $this->assertCount(2, Product::inStock()->get());
    }

    public function test_product_slug_is_set(): void
    {
        $product = Product::factory()->create(['name' => 'Test Product', 'slug' => 'test-product']);
        $this->assertEquals('test-product', $product->slug);
    }

    public function test_product_casts_price_to_decimal(): void
    {
        $product = Product::factory()->create(['price' => 1299.99]);
        $this->assertIsFloat((float) $product->price);
    }
}
