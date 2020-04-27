<?php

namespace App\Services;

use App\Models\Author;

class AuthorService {

    public function create($data) {
        return Author::create($this->sanitizeInput($data));
    }

    public function firstWithName($name) {
        if(strpos($name, " ") === false) {
            return Author::where(function($query) use($name) {
                $query->where("given_name", "LIKE", "{$name}%")
                    ->orWhere("family_name", "LIKE", "{$name}%");
            })->first();
        } else {
            $data = $this->sanitizeInput(["name" => $name]);
            return Author::where(function($query) use($data) {
                $query->where("given_name", $data['given_name'])
                    ->where("family_name", "LIKE", "{$data['family_name']}%");
            })->first();
        }
    }

    public function sanitizeInput($input) {
        return [
            'given_name' => $input['given_name'] ?? implode(" ", array_slice(explode(" ", $input['name']), 0, -1)),
            'family_name' => $input['family_name'] ?? array_slice(explode(" ", $input["name"]), -1)[0],
        ];
    }

}