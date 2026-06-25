<?php

use App\Models\User;
use App\Models\Category;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_approved' => true,
    ]);
    $this->actingAs($this->admin);
});

test('admin can view categories page', function () {
    $response = $this->get(route('admin.categories.index'));
    $response->assertStatus(200);
});

test('admin can create a main category', function () {
    $response = $this->post(route('admin.categories.store'), [
        'name' => 'Clothing',
        'parent_id' => null,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['name' => 'Clothing', 'parent_id' => null]);
});

test('admin can create a subcategory', function () {
    $main = Category::create(['name' => 'Beauty']);

    $response = $this->post(route('admin.categories.store'), [
        'name' => 'Perfume',
        'parent_id' => $main->id,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['name' => 'Perfume', 'parent_id' => $main->id]);
});

test('admin can edit a category', function () {
    $category = Category::create(['name' => 'Old Name']);

    $response = $this->put(route('admin.categories.update', $category), [
        'name' => 'New Name',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'New Name']);
});

test('admin can delete a category with no children', function () {
    $category = Category::create(['name' => 'To Delete']);

    $response = $this->delete(route('admin.categories.destroy', $category));

    $response->assertRedirect();
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('admin cannot delete a category with children', function () {
    $main = Category::create(['name' => 'Main']);
    Category::create(['name' => 'Sub', 'parent_id' => $main->id]);

    $response = $this->delete(route('admin.categories.destroy', $main));

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['id' => $main->id]); // Still exists
});