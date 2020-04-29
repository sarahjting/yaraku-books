<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use Tests\Traits\TestsXML;

class AuthorTest extends TestCase
{
    use WithFaker, TestsXML;

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
}
