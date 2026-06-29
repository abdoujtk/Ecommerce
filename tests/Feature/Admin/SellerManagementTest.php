<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_approved' => true,
    ]);
    $this->actingAs($this->admin);
});

test('admin can view sellers list', function () {
    User::factory()->create(['role' => 'seller', 'name' => 'Ahmed']);

    $response = $this->get(route('admin.sellers.index'));

    $response->assertStatus(200);
    $response->assertSee('Ahmed');
});

test('admin can approve a seller', function () {
    $seller = User::factory()->create([
        'role' => 'seller',
        'is_approved' => false,
    ]);

    $this->post(route('admin.sellers.approve', $seller));

    $this->assertDatabaseHas('users', [
        'id' => $seller->id,
        'is_approved' => true,
    ]);
});

test('admin can ban a seller', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_banned' => false]);

    $this->post(route('admin.sellers.ban', $seller));

    $this->assertDatabaseHas('users', [
        'id' => $seller->id,
        'is_banned' => true,
    ]);
});

test('admin can unban a seller', function () {
    $seller = User::factory()->create(['role' => 'seller', 'is_banned' => true]);

    $this->post(route('admin.sellers.unban', $seller));

    $this->assertDatabaseHas('users', [
        'id' => $seller->id,
        'is_banned' => false,
    ]);
});

test('admin can delete a seller', function () {
    $seller = User::factory()->create(['role' => 'seller']);

    $this->delete(route('admin.sellers.destroy', $seller));

    $this->assertDatabaseMissing('users', ['id' => $seller->id]);
});