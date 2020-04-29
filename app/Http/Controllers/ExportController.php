<?php

namespace App\Http\Controllers;
use App\Services\BookService;

class ExportController extends Controller
{
    public function getBooks(BookService $bookService)
    {
        $books = $bookService->get();

        $fields = request()->get("fields") ? explode(",", request()->get("fields")) : null;
        
        $books = $books->toXML("books", $fields)->asXML();

        return response($books, 200, [ "Content-Type" => "application/xml" ]);
    }
}
