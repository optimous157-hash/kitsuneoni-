<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_ok(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_contains_brand_name(): void
    {
        $response = $this->get('/');
        $response->assertSee('Kitsuneoni');
    }

    public function test_about_page_returns_ok(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    public function test_contact_page_returns_ok(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_shipping_page_redirects_to_faq(): void
    {
        $response = $this->get('/shipping');
        $response->assertStatus(301);
        $response->assertRedirect(route('faq'));
    }

    public function test_loyalty_page_returns_ok(): void
    {
        $response = $this->get('/loyalty');
        $response->assertStatus(200);
    }

    public function test_faq_page_returns_ok(): void
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }
}
