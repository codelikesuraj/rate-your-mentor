<?php
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('api is healthy', function () {
    $this->getJson('/api/health')
        ->assertOk();
});
