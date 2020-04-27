<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\TestsGraphQL;

use Tests\TestCase;

class DeleteBookMutationTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsGraphQL;

    private function deleteBookMutationSignature() 
    {
        return 'mutation deleteBook($id: Int!) { deleteBook(id: $id) }';
    }

    public function test_can_delete_book()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertDatabaseHas("books", ["id" => $book->id]);
        
        $response = $this->callGraphQL(
            $this->deleteBookMutationSignature(),
            [ "id" => $book->id ],
        );

        $this->assertGraphQLFragment($response, ["deleteBook" => true]);
        $this->assertDatabaseMissing("books", ["id" => $book->id]);
    }

    public function test_cannot_delete_book_that_does_not_exist()
    {
        $response = $this->callGraphQL(
            $this->deleteBookMutationSignature(),
            [ "id" => 1 ],
        );

        $this->assertGraphQLFragment($response, ["deleteBook" => false]);
    }
}
