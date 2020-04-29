<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\TestsXML;

use App\Models\Collections\XMLFormattableCollection;

use Tests\TestCase;

class ExportAuthorsTest extends TestCase
{
    use RefreshDatabase, TestsXML;

    public function test_can_export_empty_xml()
    {
        $response = $this->get("/export/authors");

        $response->assertStatus(200);
        $this->assertXmlEquals($response->getContent(), "<authors/>");
    }

    public function test_can_export_xml()
    {
        $authors = new XMLFormattableCollection(factory(\App\Models\Author::class, 10)->create());
        $response = $this->get("/export/authors");

        $response->assertStatus(200);
        $this->assertXmlEquals($authors->sortBy("family_name")->toXML("authors")->asXML(), $response->getContent());
    }
}
