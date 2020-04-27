<?php

namespace App\Services;

use App\Models\Author;

use Illuminate\Database\Eloquent\Collection;

class AuthorService {

    public function create(array $data): Author {
        return Author::create($this->sanitizeInput($data));
    }

    public function firstOrCreate(array $data): Author {
        $author = $this->firstWithName($data["name"]);
        if($author === null) $author = $this->create($data);
        return $author;
    }

    public function firstWithName(string $name):? Author {
        $data = $this->sanitizeInput(["name" => $name]);
        return Author::where("given_name", $data['given_name'])
            ->where("family_name", $data['family_name'])
            ->first();
    }

    public function getByName(string $name):? Collection {
        if(strpos($name, " ") === false) {
            return Author::where(function($query) use($name) {
                $query->where("given_name", "LIKE", "{$name}%")
                    ->orWhere("family_name", "LIKE", "{$name}%");
            })->get();
        } else {
            $data = $this->sanitizeInput(["name" => $name]);
            return Author::where("given_name", $data['given_name'])
                    ->where("family_name", "LIKE", "{$data['family_name']}%")
                    ->get();
        }
    }

    public function sanitizeInput(array $input): array {
        return [
            'given_name' => $input['given_name'] ?? implode(" ", array_slice(explode(" ", $input['name']), 0, -1)),
            'family_name' => $input['family_name'] ?? array_slice(explode(" ", $input["name"]), -1)[0],
        ];
    }

}