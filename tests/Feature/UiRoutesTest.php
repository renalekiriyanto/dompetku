<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UiRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_protected_pages(): void
    {
        $routes = ['/', '/transactions', '/wallets', '/categories', '/reports', '/settings'];

        foreach ($routes as $uri) {
            $this->get($uri)->assertRedirect(route('login'));
        }
    }

    public function test_all_ui_pages_render_successfully_for_authenticated_users(): void
    {
        $user = User::factory()->create(['name' => 'Budi Santoso']);

        $routes = [
            '/' => 'Total Balance',
            '/transactions' => 'Transactions',
            '/wallets' => 'Wallets',
            '/categories' => 'Categories',
            '/reports' => 'Reports',
            '/settings' => 'Settings',
        ];

        foreach ($routes as $uri => $expectedText) {
            $response = $this->actingAs($user)->get($uri);

            $response->assertStatus(200);
            $response->assertSee($expectedText);
            $response->assertSee('viewport-fit=cover', false);
            $response->assertSee('app-sidebar', false);
            $response->assertSee('mobile-bottom-nav', false);
        }

        $this->actingAs($user)
            ->get(route('transactions.index'))
            ->assertSee('data-tx-mobile-wrapper', false)
            ->assertSee('data-tx-desktop-wrapper', false);
    }

    public function test_named_routes_resolve_expected_paths(): void
    {
        $this->assertSame(url('/'), route('dashboard'));
        $this->assertSame(url('/transactions'), route('transactions.index'));
        $this->assertSame(url('/wallets'), route('wallets.index'));
        $this->assertSame(url('/categories'), route('categories.index'));
        $this->assertSame(url('/reports'), route('reports.index'));
        $this->assertSame(url('/settings'), route('settings.index'));
        $this->assertSame(url('/login'), route('login'));
        $this->assertSame(url('/register'), route('register'));
    }
}
