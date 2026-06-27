<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::where('is_active', true)
            ->whereHas('store.user', function ($q) {
                $q->where('is_approved', true)
                  ->where('is_banned', false);
            })
            ->with(['mainImage', 'store', 'category']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('store', function ($q2) use ($search) {
                      $q2->where('store_name', 'like', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category)
                  ->orWhere('parent_id', $request->category);
            });
        }

        $products = $query->latest()->paginate(24);

        // Get categories for filter
        $categories = \App\Models\Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('home', compact('products', 'categories'));
    }
}