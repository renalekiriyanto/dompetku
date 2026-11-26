<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function show(): View
    {
        return view('pages.auth.login');
    }

    /**
     * Authenticate an existing user using email and password.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'auth' => 'The email or password you entered is incorrect.',
                ]);
        }

        // Prevent session fixation by regenerating the session ID after login.
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Log the authenticated user out and invalidate their session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'You have been signed out.');
    }
}
