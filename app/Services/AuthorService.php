<?php

namespace App\Services;

use App\Models\Author;

class AuthorService {

    public function firstWithName($name) {
        if(strpos($name, " ") === false) {
            return Author::where(function($query) use($name) {
                $query->where("given_name", "LIKE", "{$name}%")
                    ->orWhere("family_name", "LIKE", "{$name}%");
            })->first();
        } else {
            $givenName = implode(" ", array_slice(explode(" ", $name), 0, -1));
            $familyName = array_slice(explode(" ", $name), 1)[0];
            return Author::where(function($query) use($givenName, $familyName) {
                $query->where("given_name", $givenName)
                    ->where("family_name", "LIKE", "{$familyName}%");
            })->first();
        }
    }

}