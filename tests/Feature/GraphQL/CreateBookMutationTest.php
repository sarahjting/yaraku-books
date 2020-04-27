<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\TestsGraphQL;

use Tests\TestCase;
use Arr;

class CreateBookMutationTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsGraphQL;

    public function test_can_create_book()
    {
        $rawBook = Arr::only(factory(\App\Models\Book::class)->states("raw")->raw(), ["title", "author"]);
        
        $response = $this->callGraphQL(
            'mutation createBook($book: BookInput) { createBook(book: $book){ title author{name} } }',
            [ "book" => $rawBook ],
        );

        $this->assertGraphQLFragment($response, ["createBook" => $rawBook]);
    }
}
