<?php

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

beforeEach(function () {
    $this->seller = User::factory()->create([
        'role' => 'seller',
        'is_approved' => true,
    ]);
    Store::factory()->create(['user_id' => $this->seller->id]);
    $this->actingAs($this->seller);
});

test('seller can view orders page', function () {
    $response = $this->get(route('seller.orders.index'));
    $response->assertStatus(200);
});

test('seller can confirm a pending order', function () {
    $product = Product::factory()->create([
        'store_id' => $this->seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);

    $order = Order::create([
        'product_id' => $product->id,
        'store_id' => $this->seller->store->id,
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr 12',
        'status' => 'pending',
    ]);

    $response = $this->post(route('seller.orders.confirm', $order));
    $response->assertRedirect();
    $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'confirmed']);
});

test('seller can reject a pending order', function () {
    $product = Product::factory()->create([
        'store_id' => $this->seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);

    $order = Order::create([
        'product_id' => $product->id,
        'store_id' => $this->seller->store->id,
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr 12',
        'status' => 'pending',
    ]);

    $response = $this->post(route('seller.orders.reject', $order));
    $response->assertRedirect();
    $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'rejected']);
});

test('seller can mark confirmed order as delivered', function () {
    $product = Product::factory()->create([
        'store_id' => $this->seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);

    $order = Order::create([
        'product_id' => $product->id,
        'store_id' => $this->seller->store->id,
        'customer_name' => 'Karim',
        'customer_phone' => '0666111222',
        'customer_address' => 'Hai Nasr 12',
        'status' => 'confirmed',
    ]);

    $response = $this->post(route('seller.orders.mark-delivered', $order));
    $response->assertRedirect();
    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'delivered',
    ]);
    $this->assertNotNull(Order::find($order->id)->rating_code);
});