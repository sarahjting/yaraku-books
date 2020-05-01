<?php

namespace App\Http\Controllers;
use App\Services\BookService;
use App\Services\AuthorService;

use App\Models\Collections\XMLFormattableCollection;
use App\Models\Collections\CSVFormattableCollection;

class ExportController extends Controller
{
    public function getAuthors(AuthorService $authorService)
    {
        $authors = $authorService->getByName("");
        return $this->formatResponse("authors", $authors);
    }

    public function getBooks(BookService $bookService)
    {
        $books = $bookService->get();
        return $this->formatResponse("books", $books);
    }

    private function formatResponse($rootElementName, $data)
    {
        $format = request()->get("format");
        if(!$format) $format = request()->header("accept");
        switch($format) {
            case "text/csv": case "csv": return $this->formatCSVResponse($data);
            default: return $this->formatXMLResponse($rootElementName, $data); 
        }
    }

    private function formatXMLResponse($rootElementName, $data)
    {
        $collection = new XMLFormattableCollection($data);
        return response(
            $collection->toXML($rootElementName, $this->getFieldNames())->asXML(), 
            200, 
            [ "Content-Type" => "application/xml" ]
        );
    }

    private function formatCSVResponse($data)
    {
        $collection = new CSVFormattableCollection($data);
        return response(
            $collection->toCSV($this->getFieldNames()), 
            200, 
            [ "Content-Type" => "text/csv" ]
        );
    }

    private function getFieldNames()
    {
        return request()->get("fields") ? explode(",", request()->get("fields")) : null;
    }
}
