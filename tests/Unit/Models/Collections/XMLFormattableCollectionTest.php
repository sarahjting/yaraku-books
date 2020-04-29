<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Tests\Traits\TestsXML;

use App\Models\Collections\XMLFormattableCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Arr;
use SimpleXMLElement;

class FormattableCollectionTest extends TestCase
{
    use RefreshDatabase, TestsXML;

    public function test_can_format_collection_into_xml() 
    {
        $authors = new XMLFormattableCollection(factory(\App\Models\Author::class, 5)->create());
        
        $this->assertXMLEquals($authors->toXML("authors")->asXml(), "<authors>" . $authors->map(function($author) {
            return "<author><id>{$author->id}</id><name>{$author->name}</name></author>";
        })->implode("") . "</authors>");
    }

    public function test_can_format_collection_into_xml_with_custom_fields() 
    {
        $authors = new XMLFormattableCollection(factory(\App\Models\Author::class, 5)->create());

        $this->assertXMLEquals($authors->toXML("authors", ["given_name"])->asXml(), "<authors>" . $authors->map(function($author) {
            return "<author><givenName>{$author->given_name}</givenName></author>";
        })->implode("") . "</authors>");
    }

    public function test_can_format_collection_into_xml_with_nested_fields() 
    {
        $books = new XMLFormattableCollection(factory(\App\Models\Book::class, 5)->create());

        $this->assertXMLEquals($books->toXML("books", ["title", "author.name"])->asXml(), "<books>" . $books->map(function($book) {
            return "<book><title>{$book->title}</title><author><name>{$book->author->name}</name></author></book>";
        })->implode("") . "</books>");
    }
}
