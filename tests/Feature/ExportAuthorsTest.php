<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\TestsXML;
use Tests\Traits\TestsCSV;

use App\Models\Collections\XMLFormattableCollection;
use App\Models\Collections\CSVFormattableCollection;

use Tests\TestCase;

class ExportAuthorsTest extends TestCase
{
    use RefreshDatabase, TestsXML, TestsCSV;

    public function test_can_export_empty_xml()
    {
        $response = $this->get("/export/authors");

        $response->assertStatus(200);
        $this->assertXMLEquals("<authors/>", $response->getContent());
    }

    public function test_can_export_xml()
    {
        factory(\App\Models\Author::class, 10)->create();
        $response = $this->get("/export/authors");

        $response->assertStatus(200);

        $authors = new XMLFormattableCollection(\App\Models\Author::orderByName()->get());
        $this->assertXMLEquals($authors->toXML("authors")->asXML(), $response->getContent());
    }

    public function test_can_export_xml_with_custom_fields()
    {
        factory(\App\Models\Author::class, 10)->create();
        $response = $this->get("/export/authors?fields=given_name");

        $response->assertStatus(200);

        $authors = new XMLFormattableCollection(\App\Models\Author::orderByName()->get());
        $this->assertXMLEquals($authors->toXML("authors", ["given_name"])->asXML(), $response->getContent());
    }

    public function test_can_export_csv()
    {
        factory(\App\Models\Author::class, 10)->create();
        $authors = new CSVFormattableCollection(\App\Models\Author::orderByName()->get());
        $responses = [
            $response = $this->get("/export/authors?fields=id,name", [
                "accept" => "text/csv"
            ]),
            $response = $this->get("/export/authors?fields=id,name&format=csv"),
        ];

        foreach($responses as $response) {
            $response->assertStatus(200);
            $this->assertCSVEquals($authors->toCSV(["id", "name"]), $response->getContent());
        }
    }
}
