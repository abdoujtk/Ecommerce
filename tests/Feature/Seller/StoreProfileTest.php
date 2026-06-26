<?php

use App\Models\User;
use App\Models\Store;

beforeEach(function () {
    $this->seller = User::factory()->create([
        'role' => 'seller',
        'is_approved' => true,
    ]);
    Store::factory()->create([
        'user_id' => $this->seller->id,
        'store_name' => 'My Store',
        'phone' => '0666123456',
    ]);
    $this->actingAs($this->seller);
});

test('seller can view store edit page', function () {
    $response = $this->get(route('seller.store.edit'));
    $response->assertStatus(200);
    $response->assertSee('My Store');
});

test('seller can update store profile', function () {
    $response = $this->put(route('seller.store.update'), [
        'store_name' => 'New Store Name',
        'phone' => '0666999999',
    ]);

    $response->assertRedirect(route('seller.dashboard'));
    $this->assertDatabaseHas('stores', [
        'user_id' => $this->seller->id,
        'store_name' => 'New Store Name',
        'phone' => '0666999999',
    ]);
});