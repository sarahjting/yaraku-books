<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use Tests\Traits\TestsXML;

class AuthorTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestsXML;

    public function test_can_get_name()
    {
        $givenName = $this->faker->firstName();
        $familyName = $this->faker->lastName();

        $author = factory(\App\Models\Author::class)->create([
            "given_name" => $givenName,
            "family_name" => $familyName,
        ]);   

        $this->assertEquals($author->name, "{$givenName} {$familyName}");
    }

    public function test_can_format_to_xml_with_default_fields()
    {
        $author = factory(\App\Models\Author::class)->create();

        $this->assertXMLEquals("<author><id>{$author->id}</id><name>{$author->name}</name></author>", $author->toXml()->asXml());
    }

    public function test_can_format_to_xml_with_custom_fields()
    {
        $author = factory(\App\Models\Author::class)->create();

        $this->assertXMLEquals("<author><givenName>{$author->given_name}</givenName></author>", $author->toXml(null, ["given_name"])->asXml());
    }

    public function test_can_format_field_to_xml()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXMLEquals("<books><book><id>{$book->id}</id></book></books>", $book->author->fieldToXML("books", ["id"])->asXml());
    }
}
