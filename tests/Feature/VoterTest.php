<?php

use App\Models\Voter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

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
