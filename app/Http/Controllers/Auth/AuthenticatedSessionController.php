<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate with phone instead of email
        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'phone' => 'The provided credentials do not match our records.',
            ])->onlyInput('phone');
        }

        $user = Auth::user();

        // Check if banned
        if ($user->is_banned) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'phone' => 'Your account has been suspended. Please contact support.',
            ]);
        }

        // Check if seller is approved
        if ($user->isSeller() && !$user->is_approved) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'phone' => 'Your account is pending approval. You will be able to log in once an admin approves your account.',
            ]);
        }

        // Regenerate session (security best practice)
        $request->session()->regenerate();

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('seller.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}