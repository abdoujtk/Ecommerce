<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_approved' => true,
    ]);
    $this->actingAs($this->admin);
});

test('admin can view all orders', function () {
    $response = $this->get(route('admin.orders.index'));
    $response->assertStatus(200);
});

test('non-admin cannot access admin orders', function () {
    $seller = User::factory()->create(['role' => 'seller']);

    $response = $this->actingAs($seller)->get(route('admin.orders.index'));
    $response->assertRedirect(route('seller.dashboard'));
});