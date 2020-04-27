<?php

namespace App\Services;

use App\Models\Author;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class AuthorService {

    public function create(array $data): Author {
        return Author::create($this->sanitizeInput($data));
    }

    public function update(Author $author, array $data): bool {
        return $author->update($this->sanitizeInput($data));
    }

    public function firstOrCreate(array $data): Author {
        $author = $this->firstWithName($data["name"]);
        if($author === null) $author = $this->create($data);
        return $author;
    }

    public function firstWithId(int $id):? Author {
        return Author::where('id', $id)->first();
    }

    public function firstWithName(string $name):? Author {
        $data = $this->sanitizeInput(["name" => $name]);
        return Author::where("given_name", $data['given_name'])
            ->where("family_name", $data['family_name'])
            ->first();
    }

    public function getByName(string $name):? Collection {
        $authors = Author::query();
        $this->modifyQueryWhereAuthorLike($authors, $name);
        return $authors->get();
    }

    public function modifyQueryWhereAuthorLike(Builder $query, string $name): Builder {
        if(strpos($name, " ") === false) {
            return $this->modifyQueryWhereAuthorNamesLike($query, $name);
        } else {
            $data = $this->sanitizeInput(["name" => $name]);
            return $this->modifyQueryWhereAuthorFullNameLike($query, $data["given_name"], $data["family_name"]);
        }
    }


    public function modifyQueryWhereAuthorNamesLike(Builder $query, string $name): Builder {
        return $query->where(function($query) use($name) {
            $query->where("given_name", "LIKE", "{$name}%")
                ->orWhere("family_name", "LIKE", "{$name}%");
        });
    }

    public function modifyQueryWhereAuthorFullNameLike(Builder $query, string $givenName, string $familyName): Builder {
        return $query->where("given_name", $givenName)->where("family_name", "LIKE", "{$familyName}%");
    }

    public function sanitizeInput(array $input): array {
        return [
            'given_name' => $input['given_name'] ?? implode(" ", array_slice(explode(" ", $input['name']), 0, -1)),
            'family_name' => $input['family_name'] ?? array_slice(explode(" ", $input["name"]), -1)[0],
        ];
    }

}