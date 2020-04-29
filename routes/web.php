<?php

use Illuminate\Support\Facades\Route;
use App\Services\BookService;

Route::group(['prefix' => '/export'], function () {
    Route::get('/books', function() {
        $bookService = new BookService;
        $books = $bookService->get();

        $fields = request()->get("fields") ? explode(",", request()->get("fields")) : null;
        
        $books = $books->toXML("books", $fields)->asXML();

        return response($books, 200, [ "Content-Type" => "application/xml" ]);
    });
});
