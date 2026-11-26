<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the registration page.
     */
    public function show(): View
    {
        return view('pages.auth.register');
    }

    /**
     * Create a new user account and sign the user in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Password hashing is handled automatically by User's 'password' => 'hashed' cast.
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
