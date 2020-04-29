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

        $this->assertXmlEquals($book->toXml()->asXml(), "<book><id>{$book->id}</id><title>{$book->title}</title></book>");
    }

    public function test_can_format_to_xml_with_custom_fields()
    {
        $book = factory(\App\Models\Book::class)->create();

        $this->assertXmlEquals($book->toXml(["created_at"])->asXml(), "<book><createdAt>{$book->created_at}</createdAt></book>");
    }
}
