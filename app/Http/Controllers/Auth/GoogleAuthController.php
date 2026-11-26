<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirect(): RedirectResponse
    {
        if (! $this->isConfigured()) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'Google Sign-In is not configured yet. Please add GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, and GOOGLE_REDIRECT_URI to your .env file.',
                ]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the OAuth callback from Google and sign the user in.
     */
    public function callback(Request $request): RedirectResponse
    {
        if (! $this->isConfigured()) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'Google Sign-In is not configured yet.',
                ]);
        }

        if ($request->filled('error')) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'Google sign-in was cancelled or denied. Please try again.',
                ]);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            Log::warning('Google OAuth callback failed.', [
                'exception' => $exception::class,
            ]);

            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'Unable to sign in with Google right now. Please try again.',
                ]);
        }

        $googleId = (string) $googleUser->getId();
        $email = Str::lower(trim((string) $googleUser->getEmail()));
        $rawAttributes = $googleUser->user ?? [];

        if ($googleId === '' || $email === '') {
            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'Google did not provide a valid account email address.',
                ]);
        }

        if (array_key_exists('email_verified', $rawAttributes) && $rawAttributes['email_verified'] === false) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'Please verify your Google account email address before signing in.',
                ]);
        }

        $user = User::where('google_id', $googleId)->first()
            ?? User::where('email', $email)->first();

        if ($user) {
            if ($user->google_id !== null && $user->google_id !== $googleId) {
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'auth' => 'This email address is already linked to a different Google account.',
                    ]);
            }

            if ($user->google_id === null) {
                $user->google_id = $googleId;
            }

            if ($user->email_verified_at === null) {
                $user->email_verified_at = now();
            }

            if ($user->isDirty()) {
                $user->save();
            }
        } else {
            $user = new User([
                'name' => $googleUser->getName() ?: Str::before($email, '@'),
                'email' => $email,
                'google_id' => $googleId,
                'password' => null,
            ]);
            $user->email_verified_at = now();
            $user->save();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Check whether Google OAuth credentials are configured.
     */
    private function isConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }
}
