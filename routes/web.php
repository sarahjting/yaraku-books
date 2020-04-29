<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/export'], function () {
    Route::get('/books', 'ExportController@getBooks');
});
