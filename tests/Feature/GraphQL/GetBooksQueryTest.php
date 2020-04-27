<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\TestsGraphQL;

use Tests\TestCase;

use Arr;
use DB;

class GetBooksQueryTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsGraphQL;

    public function test_can_retrieve_no_books()
    {
        $response = $this->callGraphQL("query{ books{ id title } }");

        $response->assertStatus(200);
        $this->assertGraphQLFragment($response, ["books" => []]);
    }

    public function test_can_retrieve_all_books()
    {
        $books = factory(\App\Models\Book::class, 10)->create();

        $response = $this->callGraphQL("query{ books{ id title } }");

        $response->assertStatus(200);
        $this->assertGraphQLFragment($response, ["books" => $books->map(function($el) {
            return $el->only("id", "title");
        })]);
    }

    public function test_can_retrieve_authors_of_books()
    {
        $books = factory(\App\Models\Book::class, 10)->create();

        $response = $this->callGraphQL("query{ books{ id title author{name} } }");

        $response->assertStatus(200);
        $this->assertGraphQLFragment($response, ["books" => $books->map(function($el) {
            return $el->only(["id", "title"]) + ["author" => $el->author->only("name")];
        })]);
    }
}
