<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['product', 'store', 'review']);

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'delivered', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Filter by store
        if ($request->has('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        $orders = $query->latest()->paginate(20);

        // Get all stores for filter dropdown
        $stores = \App\Models\Store::with('user')->get();

        return view('admin.orders.index', compact('orders', 'stores'));
    }
}