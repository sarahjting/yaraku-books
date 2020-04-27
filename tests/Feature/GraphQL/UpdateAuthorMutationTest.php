<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\TestsGraphQL;

use Tests\TestCase;
use Arr;

class UpdateAuthorMutationTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsGraphQL;

    private function updateAuthorMutationSignature() 
    {
        return 'mutation updateAuthor($id: Int!, $author: AuthorInput!) { updateAuthor(id: $id, author: $author){ name } }';
    }

    public function test_can_update_author()
    {
        $author = factory(\App\Models\Author::class)->create();
        $rawAuthor = factory(\App\Models\Author::class)->make();
        $updateData = ["name" => $rawAuthor->name];
        
        $response = $this->callGraphQL(
            $this->updateAuthorMutationSignature(),
            [ 
                "id" => $author->id,
                "author" => $updateData,
            ],
        );

        $this->assertGraphQLFragment($response, ["updateAuthor" => $updateData]);
        $this->assertDatabaseHas("authors", ["id" => $author->id, "family_name" => $rawAuthor->family_name ]);
        $this->assertDatabaseMissing("authors", ["given_name" => $author->given_name]);
    }

    public function test_cannot_update_author_that_does_not_exist()
    {
        $updateData = ["name" => $this->faker->name()];
        
        $response = $this->callGraphQL(
            $this->updateAuthorMutationSignature(),
            [ 
                "id" => 1,
                "author" => $updateData,
            ],
        );

        $this->assertGraphQLFragment($response, ["updateAuthor" => null]);
    }

    public function test_cannot_update_author_with_no_name()
    {
        $author = factory(\App\Models\Author::class)->create();
        $updateData = ["name" => ""];
        
        $response = $this->callGraphQL(
            $this->updateAuthorMutationSignature(),
            [ 
                "id" => $author->id,
                "author" => $updateData,
            ],
        );

        $response->assertJsonStructure(["errors"]);
    }
}
