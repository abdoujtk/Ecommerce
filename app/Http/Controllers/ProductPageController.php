<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPageController extends Controller
{
    /**
     * Show the product page.
     */
    public function show(string $uniqueLink): View
    {
        $product = Product::where('unique_link', $uniqueLink)
            ->where('is_active', true)
            ->whereHas('store.user', function ($q) {
                $q->where('is_approved', true)
                  ->where('is_banned', false);
            })
            ->with(['images', 'store', 'category.parent'])
            ->firstOrFail();

        // Record view
        $product->views()->create([
            'viewed_at' => now(),
            'source' => request()->get('source'),
        ]);

        // Increment view count
        $product->increment('view_count');

        return view('product-page', compact('product'));
    }

    /**
     * Handle order submission.
     */
    public function order(Request $request, string $uniqueLink): RedirectResponse
    {
        $product = Product::where('unique_link', $uniqueLink)
            ->where('is_active', true)
            ->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'customer_note' => 'nullable|string|max:500',
        ]);

        Order::create([
            'product_id' => $product->id,
            'store_id' => $product->store_id,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'customer_note' => $validated['customer_note'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Order placed successfully! The seller will contact you soon.');
    }
}