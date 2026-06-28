<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RatingController extends Controller
{
    /**
     * Show the rating page.
     */
    public function show(string $ratingCode): View
    {
        $order = Order::where('rating_code', $ratingCode)
            ->with(['product', 'store', 'review'])
            ->firstOrFail();

        // Check if already rated
        if ($order->review) {
            return view('rating', [
                'order' => $order,
                'alreadyRated' => true,
            ]);
        }

        return view('rating', [
            'order' => $order,
            'alreadyRated' => false,
        ]);
    }

    /**
     * Submit a rating.
     */
    public function store(Request $request, string $ratingCode): RedirectResponse
    {
        $order = Order::where('rating_code', $ratingCode)
            ->where('status', 'delivered')
            ->firstOrFail();

        // Prevent duplicate ratings
        if ($order->review) {
            return back()->with('error', 'You have already rated this purchase.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'order_id' => $order->id,
            'product_id' => $order->product_id,
            'store_id' => $order->store_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Thank you for your rating!');
    }
}