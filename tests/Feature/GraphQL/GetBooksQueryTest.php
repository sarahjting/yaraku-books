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
        $this->assertGraphQLFragment($response, ["books" => $books->sortBy("title")->values()->map(function($el) {
            return $el->only("id", "title");
        })]);
    }

    public function test_can_retrieve_authors_of_books()
    {
        $books = factory(\App\Models\Book::class, 10)->create();

        $response = $this->callGraphQL("query{ books{ id title author{name} } }");

        $response->assertStatus(200);
        $this->assertGraphQLFragment($response, ["books" => $books->sortBy("title")->values()->map(function($el) {
            return $el->only(["id", "title"]) + ["author" => $el->author->only("name")];
        })]);
    }

    public function test_can_retrieve_all_books_ordered_by_title()
    {
        $books = factory(\App\Models\Book::class, 10)->create();

        $responseAsc = $this->callGraphQL('query{ books(orderBy: TITLE_ASC){ id title } }');
        $responseDesc = $this->callGraphQL('query{ books(orderBy: TITLE_DESC){ id title } }');

        $this->assertSame(
            Arr::pluck($responseAsc->json()["data"]["books"], "id"),
            $books->sortBy("title")->pluck("id")->toArray()
        );
        $this->assertSame(
            Arr::pluck($responseDesc->json()["data"]["books"], "id"),
            $books->sortByDesc("title")->pluck("id")->toArray()
        );
    }

    public function test_can_retrieve_all_books_ordered_by_author()
    {
        $books = factory(\App\Models\Book::class, 10)->create();

        $responseAsc = $this->callGraphQL('query{ books(orderBy: AUTHOR_ASC){ id title } }');
        $responseDesc = $this->callGraphQL('query{ books(orderBy: AUTHOR_DESC){ id title } }');

        $this->assertSame(
            Arr::pluck($responseAsc->json()["data"]["books"], "id"),
            $books->sortBy("author.family_name")->pluck("id")->toArray()
        );
        $this->assertSame(
            Arr::pluck($responseDesc->json()["data"]["books"], "id"),
            $books->sortByDesc("author.family_name")->pluck("id")->toArray()
        );
    }

    public function test_can_retrieve_all_books_filtered_by_title()
    {
        $books = factory(\App\Models\Book::class, 10)->create();
        $title = $books[5]->title;
        $partialTitle = substr($books[5]->title, 0, 5);

        $responseExact = $this->callGraphQL("query{ books(title: \"{$title}\"){ id title } }");
        $responsePartial = $this->callGraphQL("query{ books(title: \"{$partialTitle}\"){ id title } }");
        
        foreach($responseExact["data"]["books"] as $book) {
            $this->assertEquals($title, $book["title"]);
        }

        foreach($responsePartial["data"]["books"] as $book) {
            $this->assertStringStartsWith($partialTitle, $book["title"]);
        }
    }

    public function test_can_retrieve_all_books_filtered_by_author()
    {
        $book = factory(\App\Models\Book::class, 10)->create()[5];

        $responses = [
            $this->callGraphQL("query{ books(author: \"{$book->author->given_name}\"){ id title } }"),
            $this->callGraphQL("query{ books(author: \"" . substr($book->author->given_name, 0, 5) . "\"){ id title } }"),
            $this->callGraphQL("query{ books(author: \"{$book->author->family_name}\"){ id title } }"),
            $this->callGraphQL("query{ books(author: \"" . substr($book->author->family_name, 0, 5) . "\"){ id title } }"),
            $this->callGraphQL("query{ books(author: \"{$book->author->given_name} {$book->author->family_name}\"){ id title } }"),
            $this->callGraphQL("query{ books(author: \"{$book->author->given_name} " . substr($book->author->family_name, 0, 5) . "\"){ id title } }"),
        ];
        
        foreach($responses as $response) {
            $this->assertEquals(count($response["data"]["books"]), 1);
        }
    }
}
