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

    public function test_can_find_author_by_name()
    {
        $author = factory(\App\Models\Author::class, 5)->create()[0];

        $results = [
            $this->authorService->firstWithName($author->given_name),
            $this->authorService->firstWithName($author->family_name),
            $this->authorService->firstWithName("{$author->given_name} {$author->family_name}"),
            $this->authorService->firstWithName(substr($author->given_name, 0, 5)),
            $this->authorService->firstWithName(substr($author->family_name, 0, 5)),
            $this->authorService->firstWithName("{$author->given_name} " . substr($author->family_name, 0, 5)),
        ];

        foreach($results as $result) {
            $this->assertNotNull($result);
            $this->assertEquals($result->id, $author->id);
        }
    }
}
