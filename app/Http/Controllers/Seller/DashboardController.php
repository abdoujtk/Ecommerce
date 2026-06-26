<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $store = Auth::user()->store;

        if (!$store) {
            return view('seller.dashboard', [
                'store' => null,
                'stats' => null,
            ]);
        }

        $stats = [
            'total_products' => Product::where('store_id', $store->id)
                ->where('is_active', true)
                ->count(),
            'total_orders_this_month' => Order::where('store_id', $store->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'pending_orders' => Order::where('store_id', $store->id)
                ->where('status', 'pending')
                ->count(),
            'total_views_this_month' => Product::where('store_id', $store->id)
                ->whereHas('views', function ($query) {
                    $query->whereMonth('viewed_at', now()->month)
                        ->whereYear('viewed_at', now()->year);
                })
                ->withCount(['views' => function ($query) {
                    $query->whereMonth('viewed_at', now()->month)
                        ->whereYear('viewed_at', now()->year);
                }])
                ->get()
                ->sum('views_count'),
            'total_sales_this_month' => Order::where('store_id', $store->id)
                ->where('status', 'delivered')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('seller.dashboard', compact('store', 'stats'));
    }
}