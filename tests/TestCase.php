<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Note: RoleSeeder is not run automatically to avoid conflicts
        // Individual tests can call $this->seed(\Database\Seeders\RoleSeeder::class) if needed
    }
}
