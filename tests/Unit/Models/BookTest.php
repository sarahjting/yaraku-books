<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use Tests\Traits\TestsXML;

class BookTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsXML;

    public function test_can_format_to_xml_with_default_fields()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXMLEquals("<book><id>{$book->id}</id><title>{$book->title}</title></book>", $book->toXml()->asXml());
    }

    public function test_can_format_to_xml_with_custom_element()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXMLEquals("<foo><id>{$book->id}</id><title>{$book->title}</title></foo>", $book->toXml("foo")->asXml());
    }

    public function test_can_format_to_xml_with_custom_fields()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXMLEquals("<book><createdAt>{$book->created_at}</createdAt></book>", $book->toXml(null, ["created_at"])->asXml());
    }

    public function test_can_format_to_xml_with_relations()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXMLEquals(
            "<book><title>{$book->title}</title><author><id>{$book->author->id}</id><name>{$book->author->name}</name></author></book>", 
            $book->toXml(null, ["title", "author"])->asXml()
        );
    }
    
    public function test_can_format_to_xml_with_custom_relations()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXMLEquals(
            "<book><title>{$book->title}</title><author><givenName>{$book->author->given_name}</givenName><familyName>{$book->author->family_name}</familyName></author></book>",
            $book->toXml(null, ["title", "author.given_name", "author.family_name"])->asXml()
        );
    }

    public function test_can_generate_xml_fields_array()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertEquals([
            "id" => [],
            "title" => [],
            "author" => [
                "id",
                "name",
                "books.id",
            ]
        ], $book->xmlFieldNamesToArray(["id", "title", "author.id", "author.name", "author.books.id"]));
    }
}
