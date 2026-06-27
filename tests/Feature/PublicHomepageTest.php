<?php

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;

test('homepage loads', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('homepage shows approved seller products', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $category = Category::create(['name' => 'Test']);
    $product = Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => $category->id,
        'name' => 'Visible Product',
        'is_active' => true,
    ]);

    $response = $this->get('/');
    $response->assertSee('Visible Product');
});

test('homepage hides banned seller products', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true, 'is_banned' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $category = Category::create(['name' => 'Test']);
    Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => $category->id,
        'name' => 'Hidden Product',
        'is_active' => true,
    ]);

    $response = $this->get('/');
    $response->assertDontSee('Hidden Product');
});