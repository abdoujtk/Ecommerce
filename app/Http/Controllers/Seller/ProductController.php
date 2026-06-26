<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the seller's products.
     */
    public function index(): View
    {
        $store = Auth::user()->store;

        $products = Product::where('store_id', $store->id)
            ->with(['category.parent', 'mainImage'])
            ->latest()
            ->paginate(20);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $mainCategories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('seller.products.create', compact('mainCategories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $store = Auth::user()->store;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique link
        $uniqueLink = $this->generateUniqueLink();

        // Create product
        $product = Product::create([
            'store_id' => $store->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'unique_link' => $uniqueLink,
            'is_active' => Auth::user()->is_approved, // Only active if seller is approved
        ]);

        // Upload images
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_main' => $index === 0, // First image is main
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created! Share link: ' . url('/p/' . $uniqueLink));
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product): View
    {
        // Security: ensure product belongs to seller's store
        $this->authorizeProduct($product);

        $mainCategories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        $product->load(['images', 'category.parent']);

        return view('seller.products.edit', compact('product', 'mainCategories'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        // Upload new images if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'is_main' => false,
                    'order' => $product->images()->count() + 1,
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Toggle product active status (soft delete).
     */
    public function toggleActive(Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'visible' : 'hidden';
        return back()->with('success', "Product is now {$status}.");
    }

    /**
     * Delete a product and all its data.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        // Delete images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

    /**
     * Ensure the product belongs to the authenticated seller's store.
     */
    private function authorizeProduct(Product $product): void
    {
        $store = Auth::user()->store;

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Generate a unique 8-character link for a product.
     */
    private function generateUniqueLink(): string
    {
        do {
            $code = Str::random(8);
        } while (Product::where('unique_link', $code)->exists());

        return $code;
    }
}