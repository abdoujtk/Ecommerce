<?php

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;

test('product page loads', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $category = Category::create(['name' => 'Test']);
    $product = Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => $category->id,
        'is_active' => true,
    ]);

    $response = $this->get('/p/' . $product->unique_link);
    $response->assertStatus(200);
    $response->assertSee($product->name);
});

test('customer can submit order', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $category = Category::create(['name' => 'Test']);
    $product = Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => $category->id,
        'is_active' => true,
    ]);

    $response = $this->post('/p/' . $product->unique_link . '/order', [
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr 12',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('orders', [
        'product_id' => $product->id,
        'customer_name' => 'Karim',
        'status' => 'pending',
    ]);
});