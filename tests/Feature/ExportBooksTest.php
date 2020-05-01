<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\TestsXML;
use Tests\Traits\TestsCSV;

use App\Models\Collections\CSVFormattableCollection;
use App\Models\Collections\XMLFormattableCollection;

use Tests\TestCase;

class ExportBooksTest extends TestCase
{
    use RefreshDatabase, TestsXML, TestsCSV;

    public function test_can_export_empty_xml()
    {
        $response = $this->get("/export/books");

        $response->assertStatus(200);
        $this->assertXMLEquals("<books/>", $response->getContent());
    }

    public function test_can_export_xml()
    {
        $books = new XMLFormattableCollection(factory(\App\Models\Book::class, 10)->create());
        $response = $this->get("/export/books");

        $response->assertStatus(200);
        $this->assertXMLEquals($books->sortBy("title")->toXML("books")->asXML(), $response->getContent());
    }

    public function test_can_export_xml_with_custom_fields()
    {
        $books = new XMLFormattableCollection(factory(\App\Models\Book::class, 10)->create());
        $response = $this->get("/export/books?fields=title,author.name");

        $response->assertStatus(200);
        $this->assertXMLEquals($books->sortBy("title")->toXML("books", ["title", "author.name"])->asXML(), $response->getContent());
    }

    public function test_can_export_csv()
    {
        factory(\App\Models\Book::class, 10)->create();
        $books = new CSVFormattableCollection(\App\Models\Book::orderBy('title')->get());
        
        $responses = [
                $this->get("/export/books?fields=id,title,author.name", [
                    "accept" => "text/csv"
                ]),
                $this->get("/export/books?fields=id,title,author.name&format=csv")
            ];

        foreach($responses as $response) {
            $response->assertStatus(200);
            $this->assertCSVEquals($books->toCSV(["id", "title", "author.name"]), $response->getContent());
        }
    }
}
