<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\BookService;
use App\Services\AuthorService;

use Mockery;

class BookServiceTest extends TestCase
{
    use RefreshDatabase; 

    public function __construct() 
    {
        parent::__construct();
        $this->authorService = Mockery::mock(AuthorService::class);
        $this->bookService = new BookService($this->authorService); 
    }

    public function test_can_find_book_by_id() 
    {
        $book = factory(\App\Models\Book::class, 5)->create()[1];

        $result = $this->bookService->firstWithId($book->id);

        $this->assertNotNull($result);
        $this->assertEquals($result->id, $book->id);
    }

    public function test_can_delete_book()
    {
        $book = factory(\App\Models\Book::class)->create();

        $resultSuccess = $this->bookService->delete($book);
        $resultFail = $this->bookService->delete($book);

        $this->assertEquals($resultSuccess, true);
        $this->assertEquals($resultFail, false);

        $this->assertDatabaseMissing("books", ["id" => $book->id]);
    }

    public function test_can_create_book()
    {
        $rawBook = factory(\App\Models\Book::class)->states("raw")->raw();
        $author = factory(\App\Models\Author::class)->create();

        $this->authorService->shouldReceive('firstOrCreate')->once()->andReturn($author);
        
        $book = $this->bookService->create($rawBook);
        $this->assertDatabaseHas("books", [
                "title" => $rawBook["title"],
                "author_id" => $author->id,
            ]);
    }

    public function test_can_update_book()
    {
        $book = factory(\App\Models\Book::class)->create();
        $author = factory(\App\Models\Author::class)->create();
        $rawBook = factory(\App\Models\Book::class)->raw();

        $this->authorService->shouldReceive('firstOrCreate')->once()->andReturn($author);
        
        $book = $this->bookService->update($book, [
            "title" => $rawBook["title"],
            "author" => [
                "name" => $author->name
            ]
        ]);

        $this->assertDatabaseHas("books", [
                "id" => $book->id,
                "title" => $rawBook["title"],
                "author_id" => $author->id,
            ]);
    }

    public function test_can_list_books()
    {
        $books = $this->bookService->get();
        $this->assertEquals($books->count(), 0);

        factory(\App\Models\Book::class, 5)->create();
        $books = $this->bookService->get();
        $this->assertEquals($books->count(), 5);
    }

    public function test_can_list_books_sorted_by_author()
    {
        $books = factory(\App\Models\Book::class, 5)->create();

        $resultDesc = $this->bookService->get([], "AUTHOR_DESC");
        $resultAsc = $this->bookService->get([], "AUTHOR_ASC");

        $this->assertEquals(
            $resultDesc->pluck("author.family_name"), 
            $books->sortByDesc("author.family_name")->pluck("author.family_name")
        );
        $this->assertEquals(
            $resultAsc->pluck("author.family_name"), 
            $books->sortBy("author.family_name")->pluck("author.family_name")
        );
    }

    public function test_can_list_books_sorted_by_title()
    {
        $books = factory(\App\Models\Book::class, 5)->create();

        $resultAsc = $this->bookService->get([], "TITLE_ASC");
        $resultDesc = $this->bookService->get([], "TITLE_DESC");
        
        $this->assertEquals($resultAsc->pluck("title"), $books->sortBy("title")->pluck("title"));
        $this->assertEquals($resultDesc->pluck("title"), $books->sortByDesc("title")->pluck("title"));
    }

    public function test_can_list_books_filtered_by_title()
    {
        $books = factory(\App\Models\Book::class, 10)->create();
        $title = $books[5]->title;
        $partialTitle = substr($books[5]->title, 0, 5);
        
        $responseExact = $this->bookService->get(["title" => $title]);
        $responsePartial = $this->bookService->get(["title" => $partialTitle]);

        foreach($responseExact as $book) {
            $this->assertEquals($title, $book->title);
        }

        foreach($responsePartial as $book) {
            $this->assertStringStartsWith($partialTitle, $book->title);
        }
    }
}
