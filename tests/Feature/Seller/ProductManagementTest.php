<?php

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seller = User::factory()->create([
        'role' => 'seller',
        'is_approved' => true,
    ]);
    Store::factory()->create(['user_id' => $this->seller->id]);
    $this->actingAs($this->seller);
});

test('seller can view products list', function () {
    $response = $this->get(route('seller.products.index'));
    $response->assertStatus(200);
});

test('seller can view create product form', function () {
    $response = $this->get(route('seller.products.create'));
    $response->assertStatus(200);
});

test('seller can create a product', function () {
    $category = Category::create(['name' => 'Test Category']);

    // Create a fake image
    Storage::fake('public');
    $file = UploadedFile::fake()->image('product.jpg');

    $response = $this->post(route('seller.products.store'), [
        'name' => 'Test Product',
        'description' => 'Test description',
        'price' => 1500,
        'category_id' => $category->id,
        'images' => [$file],
    ]);

    $response->assertRedirect(route('seller.products.index'));
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
});

test('seller can delete own product', function () {
    $product = Product::factory()->create([
        'store_id' => $this->seller->store->id,
        'category_id' => Category::create(['name' => 'Cat'])->id,
    ]);

    $response = $this->delete(route('seller.products.destroy', $product));
    $response->assertRedirect();
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});