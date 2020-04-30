<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\TestsGraphQL;

use Tests\TestCase;
use Arr;

class UpdateBookMutationTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsGraphQL;

    private function updateBookMutationSignature() 
    {
        return 'mutation updateBook($id: Int!, $book: BookInput!) { updateBook(id: $id, book: $book){ title author{ name } } }';
    }

    public function test_can_update_book()
    {
        $book = factory(\App\Models\Book::class)->create();
        $rawBook = factory(\App\Models\Book::class)->states("raw")->raw();
        $updateData = Arr::only($rawBook, ["title", "author"]);
        
        $response = $this->callGraphQL(
            $this->updateBookMutationSignature(),
            [ 
                "id" => $book->id,
                "book" => $updateData,
            ],
        );

        $this->assertGraphQLFragment($response, ["updateBook" => $updateData]);
        $this->assertDatabaseHas("books", ["id" => $book->id, "title" => $updateData["title"] ]);
    }

    public function test_cannot_update_book_that_does_not_exist()
    {
        $updateData = ["title" => $this->faker->sentence(3), "author" => ["name" => $this->faker->name]];
        $response = $this->callGraphQL(
            $this->updateBookMutationSignature(),
            [ 
                "id" => 1,
                "book" => $updateData,
            ],
        );

        $this->assertGraphQLFragment($response, ["updateBook" => null]);
    }

    public function test_cannot_update_book_with_no_title()
    {
        $book = factory(\App\Models\Book::class)->create();
        $updateData = ["title" => "", "author" => ["name" => $this->faker->name]];
        
        $response = $this->callGraphQL(
            $this->updateBookMutationSignature(),
            [ 
                "id" => $book->id,
                "book" => $updateData,
            ],
        );

        $response->assertJsonStructure(["errors"]);
    }

    public function test_cannot_update_book_with_no_author()
    {
        $book = factory(\App\Models\Book::class)->create();
        $updateData = ["title" => $this->faker->sentence(3), "author" => ["name" => ""]];
        
        $response = $this->callGraphQL(
            $this->updateBookMutationSignature(),
            [ 
                "id" => $book->id,
                "book" => $updateData,
            ],
        );

        $response->assertJsonStructure(["errors"]);
    }
}
