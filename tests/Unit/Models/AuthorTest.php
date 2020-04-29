<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\Author;

class AuthorTest extends TestCase
{
    use WithFaker;

    public function test_can_get_name()
    {
        $givenName = $this->faker->firstName();
        $familyName = $this->faker->lastName();

        $author = factory(\App\Models\Author::class)->make([
            "given_name" => $givenName,
            "family_name" => $familyName,
        ]);   

        $this->assertEquals($author->name, "{$givenName} {$familyName}");
    }

    public function test_can_format_to_xml_with_default_fields()
    {
        $author = factory(\App\Models\Author::class)->make();

        $this->assertXmlEquals($author->toXml()->asXml(), "<author><givenName>{$author->given_name}</givenName><familyName>{$author->family_name}</familyName></author>");
    }

    public function test_can_format_to_xml_with_custom_fields()
    {
        $author = factory(\App\Models\Author::class)->make();

        $this->assertXmlEquals($author->toXml(["name"])->asXml(), "<author><name>{$author->name}</name></author>");
    }

    protected function assertXmlEquals($xml, $string) {
        $this->assertEquals(substr($xml, 0, 22), "<?xml version=\"1.0\"?>\n");
        $this->assertEquals(substr($xml, 22, -1), $string);
    }
}
