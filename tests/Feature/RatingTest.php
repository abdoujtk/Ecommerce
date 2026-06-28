<?php

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

test('rating page loads for delivered order', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $product = Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);
    $order = Order::create([
        'product_id' => $product->id,
        'store_id' => $seller->store->id,
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr',
        'status' => 'delivered',
        'rating_code' => 'test123code',
    ]);

    $response = $this->get('/rate/test123code');
    $response->assertStatus(200);
    $response->assertSee($product->name);
});

test('customer can submit rating', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $product = Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);
    $order = Order::create([
        'product_id' => $product->id,
        'store_id' => $seller->store->id,
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr',
        'status' => 'delivered',
        'rating_code' => 'code456',
    ]);

    $response = $this->post('/rate/code456', [
        'rating' => 5,
        'comment' => 'Great product!',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('reviews', [
        'order_id' => $order->id,
        'rating' => 5,
    ]);
});

test('cannot rate same order twice', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    Store::factory()->create(['user_id' => $seller->id]);
    $product = Product::factory()->create([
        'store_id' => $seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);
    $order = Order::create([
        'product_id' => $product->id,
        'store_id' => $seller->store->id,
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr',
        'status' => 'delivered',
        'rating_code' => 'code789',
    ]);

    // First rating
    $this->post('/rate/code789', ['rating' => 4]);
    // Second rating attempt
    $response = $this->post('/rate/code789', ['rating' => 2]);

    $response->assertRedirect();
    $this->assertDatabaseCount('reviews', 1);
});