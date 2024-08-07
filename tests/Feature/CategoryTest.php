<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('fetch categories list returns a successful response', function () {
    Category::factory()->count(3)->create();

    $this->get("/api/categories")
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json->has('data', 3));
});

test('fetch category by id returns a successful response', function () {
    $category = Category::factory()->create();

    $this->get(sprintf("/api/categories/%s", $category->id))
        ->assertOk()
        ->assertJson(['data' => ['name' => $category->name]]);
});

test('fetch category by slug returns a successful response', function () {
    $category = Category::factory()->create();

    $this->get(sprintf("/api/categories/%s", $category->slug))
        ->assertOk()
        ->assertJson(['data' => ['name' => $category->name]]);
});
