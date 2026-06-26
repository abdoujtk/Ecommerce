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
    ]);
    $this->actingAs($this->seller);
});

test('seller can view dashboard', function () {
    $response = $this->get(route('seller.dashboard'));
    $response->assertStatus(200);
});

test('unapproved seller sees warning', function () {
    $unapproved = User::factory()->create([
        'role' => 'seller',
        'is_approved' => false,
    ]);
    Store::factory()->create(['user_id' => $unapproved->id]);

    $response = $this->actingAs($unapproved)->get(route('seller.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('pending admin approval');
});