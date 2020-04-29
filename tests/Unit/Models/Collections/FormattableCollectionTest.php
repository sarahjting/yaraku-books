<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Tests\Traits\TestsXML;

use App\Models\Collections\FormattableCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Arr;
use SimpleXMLElement;

class FormattableCollectionTest extends TestCase
{
    use RefreshDatabase, TestsXML;

    public function test_can_format_collection_into_xml() 
    {
        $authors = factory(\App\Models\Author::class, 5)->create();
        $this->assertXMLEquals($authors->toXML()->asXml(), "<authors>" . $authors->map(function($author) {
            return "<author><id>{$author->id}</id><name>{$author->name}</name></author>";
        })->implode("") . "</authors>");
    }

    public function test_can_format_collection_into_xml_with_custom_fields() 
    {
        $authors = factory(\App\Models\Author::class, 5)->create();
        $this->assertXMLEquals($authors->toXML(["given_name"])->asXml(), "<authors>" . $authors->map(function($author) {
            return "<author><givenName>{$author->given_name}</givenName></author>";
        })->implode("") . "</authors>");
    }
}
