<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\TestsGraphQL;

use Tests\TestCase;

class GetBooksQueryTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsGraphQL;

    public function test_can_retrieve_no_books()
    {
        $response = $this->callGraphQL("query{ books{ id } }");

        $response->assertStatus(200);
        $this->assertGraphQLFragment($response, ["books" => []]);
    }
}
