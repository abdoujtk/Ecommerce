<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the seller's orders.
     */
    public function index(Request $request): View
    {
        $store = Auth::user()->store;

        $query = Order::where('store_id', $store->id)
            ->with(['product', 'review']);

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'delivered', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Confirm a pending order.
     */
    public function confirm(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be confirmed.');
        }

        $order->update(['status' => 'confirmed']);

        return back()->with('success', 'Order confirmed.');
    }

    /**
     * Reject a pending order.
     */
    public function reject(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be rejected.');
        }

        $order->update(['status' => 'rejected']);

        return back()->with('success', 'Order rejected.');
    }

    /**
     * Mark a confirmed order as delivered and generate rating code.
     */
    public function markDelivered(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed orders can be marked as delivered.');
        }

        // Generate unique rating code
        $ratingCode = $this->generateRatingCode();

        $order->update([
            'status' => 'delivered',
            'rating_code' => $ratingCode,
        ]);

        $ratingLink = url('/rate/' . $ratingCode);

        return back()->with('success', "Order delivered! Rating link: {$ratingLink}");
    }

    /**
     * Ensure the order belongs to the seller's store.
     */
    private function authorizeOrder(Order $order): void
    {
        $store = Auth::user()->store;

        if ($order->store_id !== $store->id) {
            abort(403);
        }
    }

    /**
     * Generate a unique rating code.
     */
    private function generateRatingCode(): string
    {
        do {
            $code = Str::random(12);
        } while (Order::where('rating_code', $code)->exists());

        return $code;
    }
}