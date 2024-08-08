<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test("fetch categories list returns 'OK' (200) response", function () {
    $count = (new \Faker\Generator())->randomDigitNotZero();

    Category::factory()->count($count)->create();

    $this->get("api/categories")
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json->has('data', $count));
});

test("fetch category by id & slug returns 'OK' (200) response", function () {
    $category = Category::factory()->create();

    $this->get(sprintf("api/categories/%s", $category->id))
        ->assertOk()
        ->assertJson(['data' => ['name' => $category->name]]);

    $this->get(sprintf("api/categories/%s", $category->slug))
        ->assertOk()
        ->assertJson(['data' => ['name' => $category->name]]);
});

test("fetch category by invalid id & slug returns a 'Not Found' (404) response", function () {
    $this->get("api/categories/99")
        ->assertNotFound();

    $this->get("api/categories/invalid-slug")
        ->assertNotFound();
});