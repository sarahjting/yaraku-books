<?php

namespace Tests\Unit\Models;

use App\Models\Author;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class AuthorTest extends TestCase
{
    use WithFaker; 

    public function test_can_get_name()
    {
        $givenName = $this->faker->firstName();
        $familyName = $this->faker->lastName();

        $author = factory(\App\Models\Author::class)->make([
            "given_name" => $givenName,
            "family_name" => $familyName,
        ]);   

        $this->assertEquals($author->name, "{$givenName} {$familyName}");
    }
}
