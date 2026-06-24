<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_sellers' => User::where('role', 'seller')->count(),
            'pending_approvals' => User::where('role', 'seller')
                ->where('is_approved', false)
                ->count(),
            'total_products' => Product::where('is_active', true)->count(),
            'total_orders' => Order::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}