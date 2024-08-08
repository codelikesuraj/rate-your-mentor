<?php

use App\Models\Mentor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test("fetch mentors list returns 'OK' (200) response", function () {
    $count = (new \Faker\Generator())->randomDigitNotZero();

    Mentor::factory()->count($count)->create();

    $this->get('api/mentors')
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) => $json->has('data', $count));
});

test("fetch mentor by id & slug returns 'OK' (200) response", function () {
    $mentor = Mentor::factory()->create();

    $this->get(sprintf("api/mentors/%s", $mentor->id))
        ->assertOk()
        ->assertJson(['data' => ['name' => $mentor->name]]);
});

test("fetch mentor by invalid id returns a 'Not Found' (404) response", function () {
    $this->get("api/mentors/99")
        ->assertNotFound();
});
