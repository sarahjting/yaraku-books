<?php

namespace App\Http\Controllers;
use App\Services\BookService;
use App\Services\AuthorService;

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
        $fields = request()->get("fields") ? explode(",", request()->get("fields")) : null;

        return response(
            $data->toXML($rootElementName, $fields)->asXML(), 
            200, 
            [ "Content-Type" => "application/xml" ]
        );
    }
}
