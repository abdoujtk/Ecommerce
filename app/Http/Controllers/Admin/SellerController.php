<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerController extends Controller
{
    public function index(): View
    {
        $sellers = User::where('role', 'seller')
            ->with('store')
            ->latest()
            ->paginate(20);

        return view('admin.sellers.index', compact('sellers'));
    }

    public function approve(User $user): RedirectResponse
    {
        if (!$user->isSeller()) {
            abort(403);
        }

        $user->update(['is_approved' => true]);

        return back()->with('success', "{$user->name}'s store has been approved.");
    }

    public function ban(User $user): RedirectResponse
    {
        if (!$user->isSeller()) {
            abort(403);
        }

        $user->update(['is_banned' => true]);

        return back()->with('success', "{$user->name} has been banned.");
    }

    public function unban(User $user): RedirectResponse
    {
        if (!$user->isSeller()) {
            abort(403);
        }

        $user->update(['is_banned' => false]);

        return back()->with('success', "{$user->name} has been unbanned.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if (!$user->isSeller()) {
            abort(403);
        }

        $user->delete();

        return back()->with('success', "{$user->name} and all their data have been deleted.");
    }
}