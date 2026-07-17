<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->admin()->create([
            'email' => 'admin@kitsuneoni.com',
        ]);
    }

    public function test_admin_login_page_returns_ok(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_admin_login_with_valid_credentials(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post('/admin/login', [
            'email' => 'admin@kitsuneoni.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_login_with_invalid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@kitsuneoni.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_redirects_to_login_when_unauthenticated(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_access_when_authenticated(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_access_admin(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($user);

        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_logout(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->post('/admin/logout');
        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
