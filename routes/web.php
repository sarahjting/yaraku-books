<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view("welcome");
});

Route::group(['prefix' => '/export'], function () {
    Route::get('/books', 'ExportController@getBooks');
    Route::get('/authors', 'ExportController@getAuthors');
});
