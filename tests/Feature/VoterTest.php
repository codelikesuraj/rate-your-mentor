<?php

use App\Models\Category;
use App\Models\Mentor;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test("new voter is added to DB", function () {
    $this->getJson("api/health")
        ->assertOk();

    $this->assertDatabaseCount("voters", 1);
});

test("old/recognised voter is not added to DB", function () {
    for ($i = 0; $i < 10; $i++) {
        $this->getJson("api/health")
            ->assertOk();
    }

    $this->assertDatabaseCount("voters", 1);
});

test("voters vote is saved to DB", function () {
    $faker = new Faker\Generator();

    $category_count = $faker->randomDigitNotZero;
    $mentor_count = $faker->randomDigitNotZero;

    $categories = Category::factory()->count($category_count)->create();
    $mentors = Mentor::factory()->count($mentor_count)->create();

    $this->assertDatabaseCount((new Category())->getTable(), $category_count);
    $this->assertDatabaseCount((new Mentor())->getTable(), $mentor_count);

    $random_category = $categories[rand(0, $category_count-1)];
    $random_mentor = $mentors[rand(0, $mentor_count-1)];

    $this->post("api/vote", [
        "category_id" => $random_category->id,
        "mentor_id" => $random_mentor->id
    ])->assertCreated();
    
    $this->assertDatabaseCount((new Vote())->getTable(), 1);
});
