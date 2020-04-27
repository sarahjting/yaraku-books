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

    private function createBookMutationSignature() 
    {
        return 'mutation createBook($book: BookInput!) { createBook(book: $book){ title author{name} } }';
    }

    public function test_can_create_book()
    {
        $rawBook = Arr::only(factory(\App\Models\Book::class)->states("raw")->raw(), ["title", "author"]);
        
        $response = $this->callGraphQL(
            $this->createBookMutationSignature(),
            [ "book" => $rawBook ],
        );

        $this->assertGraphQLFragment($response, ["createBook" => $rawBook]);
    }

    public function test_cannot_create_book_without_title()
    {
        $rawBook = Arr::only(factory(\App\Models\Book::class)->states("raw")->raw([
            "title" => ""
        ]), ["title", "author"]);
        
        $response = $this->callGraphQL(
            $this->createBookMutationSignature(),
            [ "book" => $rawBook ],
        );

        $response->assertJsonStructure(["errors"]);
    }

    public function test_cannot_create_book_without_author()
    {
        $rawBook = Arr::only(factory(\App\Models\Book::class)->states("raw")->raw([
            "author" => ["name" => ""]
        ]), ["title", "author"]);
        
        $response = $this->callGraphQL(
            $this->createBookMutationSignature(),
            [ "book" => $rawBook ],
        );

        $response->assertJsonStructure(["errors"]);
    }
}
