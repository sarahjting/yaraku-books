<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Tests\Traits\TestsCSV;

use App\Models\Collections\CSVFormattableCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CSVFormattableCollectionTest extends TestCase
{
    use RefreshDatabase, TestsCSV;

    public function test_can_format_collection_into_csv() 
    {
        $authors = new CSVFormattableCollection(factory(\App\Models\Author::class, 5)->create());
        
        $this->assertEquals($authors->toCSV(["id", "name"]), "id,name\n" . $authors->map(function($author) {
            return "\"{$author->id}\",\"{$author->name}\"";
        })->implode("\n"));
    }

    public function test_can_format_collection_into_csv_with_nested_fields() 
    {
        $books = new CSVFormattableCollection(factory(\App\Models\Book::class, 5)->create());

        $this->assertEquals($books->toCSV(["title", "author.name"]), "title,author.name\n" . $books->map(function($book) {
            return "\"{$book->title}\",\"{$book->author->name}\"";
        })->implode("\n"));
    }
    public function test_can_format_collection_into_csv_with_comma_input() 
    {
        factory(\App\Models\Book::class, 1)->create(["title" => "Foo, Bar"]);
        $books = new CSVFormattableCollection(\App\Models\Book::get());

        $this->assertCSVEquals([
            ["title"],
            ["Foo, Bar"]
        ], $books->toCSV(["title"]));
    }
}
