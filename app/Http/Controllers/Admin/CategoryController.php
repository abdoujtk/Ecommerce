<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display all categories (main and subcategories).
     */
    public function index(): View
    {
        // Get main categories with their subcategories
        $mainCategories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('mainCategories'));
    }

    /**
     * Store a new category (main or sub).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', // If provided, must be a valid category ID
        ]);

        Category::create($validated);

        return back()->with('success', 'Category created successfully.');
    }

    /**
     * Update a category name.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully.');
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // If it's a main category with subcategories, block deletion
        if ($category->children()->exists()) {
            return back()->with('error', 'Cannot delete this category. Remove its subcategories first.');
        }

        // If products use this category, set their category_id to null
        // (onDelete('set null') in migration handles this automatically)

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}