<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Models\Collections\CSVFormattableCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CSVFormattableCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_format_collection_into_csv() 
    {
        $authors = new CSVFormattableCollection(factory(\App\Models\Author::class, 5)->create());
        
        $this->assertEquals($authors->toCSV(["id", "name"]), "id,name\n" . $authors->map(function($author) {
            return "{$author->id},{$author->name}";
        })->implode("\n"));
    }
}
