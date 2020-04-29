<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\TestsXML;

use App\Models\Collections\XMLFormattableCollection;

use Tests\TestCase;

class ExportBooksTest extends TestCase
{
    use RefreshDatabase, TestsXML;

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
}
