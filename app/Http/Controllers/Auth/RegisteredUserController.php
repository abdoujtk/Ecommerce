<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user (seller)
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'seller',
            'is_approved' => false,  // Admin must approve first
            'is_banned' => false,
        ]);

        // Automatically create a store for the seller
        Store::create([
            'user_id' => $user->id,
            'store_name' => $request->name,  // Default: seller's name
            'phone' => $request->phone,      // Default: same as login phone
        ]);

        // Do NOT log them in automatically
        // They need admin approval first

        return redirect()->route('login')
            ->with('status', 'Registration successful! Please wait for admin approval before you can log in.');
    }
}