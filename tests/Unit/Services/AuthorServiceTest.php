<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorServiceTest extends TestCase
{
    use RefreshDatabase; 

    public function __construct() {
        parent::__construct();
        $this->authorService = new \App\Services\AuthorService; 
    }

    public function test_can_create_author()
    {
        $rawAuthor = factory(\App\Models\Author::class)->states("raw")->raw();

        $result = $this->authorService->create($rawAuthor);

        $this->assertNotNull($result);
        $this->assertEquals($result->name, $rawAuthor["name"]);
        $this->assertDatabaseHas("authors", ["given_name" => $result->given_name]);
    }

    public function test_can_find_author_by_name()
    {
        $author = factory(\App\Models\Author::class, 5)->create()[1];

        $result = $this->authorService->firstWithName("{$author->given_name} {$author->family_name}");

        $this->assertNotNull($result);
        $this->assertEquals($result->id, $author->id);
    }

    public function test_can_find_authors_by_partial_name()
    {
        $author = factory(\App\Models\Author::class, 5)->create()[1];

        $results = [
            $this->authorService->getByName($author->given_name),
            $this->authorService->getByName($author->family_name),
            $this->authorService->getByName("{$author->given_name} {$author->family_name}"),
            $this->authorService->getByName(substr($author->given_name, 0, 5)),
            $this->authorService->getByName(substr($author->family_name, 0, 5)),
            $this->authorService->getByName("{$author->given_name} " . substr($author->family_name, 0, 5)),
        ];

        foreach($results as $result) {
            $this->assertNotNull($result);
            $this->assertEquals($result[0]->id, $author->id);
        }
    }

    public function test_can_find_or_create_author()
    {
        $rawAuthor = factory(\App\Models\Author::class)->states("raw")->raw();
        
        $result1 = $this->authorService->firstOrCreate($rawAuthor);
        $result2 = $this->authorService->firstOrCreate($rawAuthor);

        $this->assertNotNull($result1);
        $this->assertNotNull($result2);

        $this->assertEquals($result1->name, $rawAuthor["name"]);
        $this->assertEquals($result1->id, $result2->id);
        $this->assertDatabaseHas("authors", ["given_name" => $result1->given_name]);
    }
}
