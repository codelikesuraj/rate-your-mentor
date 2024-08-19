<?php

use App\Models\Category;
use App\Models\Mentor;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

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

    $this->post("api/votes", [
        "category_id" => $random_category->id,
        "mentor_id" => $random_mentor->id
    ])->assertCreated();
    
    $this->assertDatabaseCount((new Vote())->getTable(), 1);
});

test("voters cannot make duplicate vote", function () {
    $faker = new Faker\Generator();

    $category_count = $faker->randomDigitNotZero;
    $mentor_count = $faker->randomDigitNotZero;

    $categories = Category::factory()->count($category_count)->create();
    $mentors = Mentor::factory()->count($mentor_count)->create();

    $this->assertDatabaseCount((new Category())->getTable(), $category_count);
    $this->assertDatabaseCount((new Mentor())->getTable(), $mentor_count);

    $random_category = $categories[rand(0, $category_count-1)];
    $random_mentor = $mentors[rand(0, $mentor_count-1)];

    $this->post("api/votes", [
        "category_id" => $random_category->id,
        "mentor_id" => $random_mentor->id
    ])->assertCreated();
    
    $this->assertDatabaseCount((new Vote())->getTable(), 1);

    $this->post("api/votes", [
        "category_id" => $random_category->id,
        "mentor_id" => $random_mentor->id
    ])->assertUnprocessable()->assertJsonValidationErrorFor("mentor_id");

    $this->assertDatabaseCount((new Vote())->getTable(), 1);
});

test("voters can only vote once per category", function () {
    $faker = new Faker\Generator();

    $category_count = $faker->randomDigitNotZero;
    $mentor_count = $faker->randomDigitNotZero;

    $categories = Category::factory()->count($category_count)->create();
    $mentors = Mentor::factory()->count($mentor_count)->create();

    $this->assertDatabaseCount((new Category())->getTable(), $category_count);
    $this->assertDatabaseCount((new Mentor())->getTable(), $mentor_count);

    $random_category = $categories[rand(0, $category_count-1)];

    $this->post("api/votes", [
        "category_id" => $random_category->id,
        "mentor_id" => $mentors[rand(0, $mentor_count-1)]->id
    ])->assertCreated();
    
    $this->assertDatabaseCount((new Vote())->getTable(), 1);

    $this->post("api/votes", [
        "category_id" => $random_category->id,
        "mentor_id" => $mentors[rand(0, $mentor_count-1)]->id
    ])->assertUnprocessable()->assertJsonValidationErrorFor("category_id");

    $this->assertDatabaseCount((new Vote())->getTable(), 1);
});

test("voters can retrieve their votes", function () {
    $faker = new Faker\Generator();

    $category_count = $faker->randomDigitNotZero;

    $categories = Category::factory()->count($category_count)->create();
    $mentor = Mentor::factory()->create();

    $this->assertDatabaseCount((new Category())->getTable(), $category_count);
    $this->assertDatabaseCount((new Mentor())->getTable(), 1);

    for ($i = 0; $i < $category_count; $i++) {
        $this->post("api/votes", [
            "category_id" => $categories[$i]->id,
            "mentor_id" => $mentor->id,
        ])->assertCreated();
    }

    $this->assertDatabaseCount((new Vote())->getTable(), $category_count);

    $this->get("api/votes")
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has($category_count)
                ->first(fn (AssertableJson $json) => 
                    $json->hasAll(['id', 'category_id', 'mentor_id', 'voter_id'])
                )
        );
});
