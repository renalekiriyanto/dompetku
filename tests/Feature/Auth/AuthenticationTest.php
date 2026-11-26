<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_without_dashboard_navigation(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Welcome back');
        $response->assertSee('Continue with Google');
        $response->assertDontSee('app-sidebar');
        $response->assertDontSee('mobile-bottom-nav');
    }

    public function test_register_page_renders_without_dashboard_navigation(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Create your account');
        $response->assertSee('Sign up with Google');
        $response->assertDontSee('app-sidebar');
        $response->assertDontSee('mobile-bottom-nav');
    }

    public function test_user_can_register_with_valid_data_and_password_is_hashed(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => 'SecretPass123!',
            'password_confirmation' => 'SecretPass123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'siti@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('Siti Aminah', $user->name);
        $this->assertNotSame('SecretPass123!', $user->password);
        $this->assertTrue(Hash::check('SecretPass123!', $user->password));
    }

    public function test_registration_rejects_invalid_and_duplicate_emails(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'SecretPass123!',
            'password_confirmation' => 'SecretPass123!',
        ])->assertSessionHasErrors('email');

        $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'password' => 'SecretPass123!',
            'password_confirmation' => 'SecretPass123!',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_user_can_login_with_valid_credentials_and_session_regenerates(): void
    {
        $user = User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'SecretPass123!',
        ]);

        $this->get(route('login'));
        $initialSessionId = session()->getId();

        $response = $this->post(route('login.store'), [
            'email' => 'budi@example.com',
            'password' => 'SecretPass123!',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($initialSessionId, session()->getId());
    }

    public function test_login_rejects_invalid_credentials_and_never_repopulates_password(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'SecretPass123!',
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => 'budi@example.com',
            'password' => 'WrongPassword!',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('auth');
        $this->assertSame('budi@example.com', session()->getOldInput('email'));
        $this->assertNull(session()->getOldInput('password'));
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout_and_session_is_invalidated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $oldToken = session()->token();

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertNotSame($oldToken, session()->token());
    }

    public function test_authenticated_users_are_redirected_away_from_guest_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('login'))->assertRedirect(route('dashboard'));
        $this->actingAs($user)->get(route('register'))->assertRedirect(route('dashboard'));
    }
}
