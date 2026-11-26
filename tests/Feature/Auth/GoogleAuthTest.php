<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_redirect_handles_missing_configuration_gracefully(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
            'services.google.redirect' => null,
        ]);

        $response = $this->get(route('auth.google.redirect'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('auth');
        $this->assertGuest();
    }

    public function test_google_callback_creates_and_authenticates_new_user(): void
    {
        $this->configureGoogleOAuth();

        $socialiteUser = new SocialiteUser;
        $socialiteUser->id = 'google-12345';
        $socialiteUser->name = 'Andi Wijaya';
        $socialiteUser->email = 'andi@example.com';
        $socialiteUser->user = ['email_verified' => true];

        $provider = Mockery::mock();
        $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
        Socialite::shouldReceive('driver')->with('google')->once()->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'andi@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('google-12345', $user->google_id);
        $this->assertNull($user->password);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_google_callback_links_existing_user_without_creating_duplicate(): void
    {
        $this->configureGoogleOAuth();

        $existingUser = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'google_id' => null,
        ]);

        $socialiteUser = new SocialiteUser;
        $socialiteUser->id = 'google-99999';
        $socialiteUser->name = 'Budi Santoso';
        $socialiteUser->email = 'budi@example.com';
        $socialiteUser->user = ['email_verified' => true];

        $provider = Mockery::mock();
        $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
        Socialite::shouldReceive('driver')->with('google')->once()->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($existingUser);
        $this->assertSame(1, User::where('email', 'budi@example.com')->count());
        $this->assertSame('google-99999', $existingUser->fresh()->google_id);
    }

    public function test_google_callback_handles_cancellation_and_exceptions_gracefully(): void
    {
        $this->configureGoogleOAuth();

        $cancelResponse = $this->get(route('auth.google.callback', ['error' => 'access_denied']));
        $cancelResponse->assertRedirect(route('login'));
        $cancelResponse->assertSessionHasErrors('auth');
        $this->assertGuest();

        $provider = Mockery::mock();
        $provider->shouldReceive('user')->once()->andThrow(new RuntimeException('OAuth token exchange failed with secret XYZ'));
        Socialite::shouldReceive('driver')->with('google')->once()->andReturn($provider);

        $errorResponse = $this->get(route('auth.google.callback'));
        $errorResponse->assertRedirect(route('login'));
        $errorResponse->assertSessionHasErrors('auth');
        $this->assertGuest();
    }

    private function configureGoogleOAuth(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'test-client-secret',
            'services.google.redirect' => 'http://localhost:8000/auth/google/callback',
        ]);
    }
}
