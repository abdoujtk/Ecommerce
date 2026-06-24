<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_approved' => true,
    ]);

    $this->actingAs($this->admin);
});

test('admin dashboard shows stats', function () {
    User::factory()->create(['role' => 'seller', 'is_approved' => true]);
    User::factory()->create(['role' => 'seller', 'is_approved' => false]);

    $response = $this->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Total Sellers');
    $response->assertSee('Pending Approvals');
    $response->assertSee('Total Products');
    $response->assertSee('Total Orders');
});

test('non-admin cannot access admin dashboard', function () {
    $seller = User::factory()->create(['role' => 'seller']);

    $response = $this->actingAs($seller)->get(route('admin.dashboard'));

    $response->assertRedirect(route('seller.dashboard'));
});