<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;

use App\Services\AuthorService; 

use Illuminate\Database\Eloquent\Collection;

class BookService {

    public function __construct(AuthorService $authorService = null) {
        $this->authorService = $authorService ?: new AuthorService;
    }

    public function firstWithId(int $id):? Book {
        return Book::where('id', $id)->first();
    }

    public function delete(Book $book): bool {
        return Book::where("id", $book->id)->delete();
    }

    public function create(array $input): Book {
        $author = $this->authorService->firstOrCreate($input["author"]);
        return Book::create([
            "title" => $input["title"],
            "author_id" => $author->id,
        ]);
    }

    public function get(array $filters = [], string $orderBy = "TITLE_ASC"): Collection {
        $query = Book::with("author");
        $joinAuthor = false; 

        switch($orderBy) {
            case "TITLE_DESC": $query->orderBy("title", "DESC"); break;
            case "TITLE_ASC": $query->orderBy("title", "ASC"); break;
            case "AUTHOR_DESC": 
                $query->orderByAuthor("DESC");
                $joinAuthor = true;  
                break;
            case "AUTHOR_ASC": 
                $query->orderByAuthor("ASC"); 
                $joinAuthor = true; 
                break;
        }

        if(isset($filters["title"])) {
            $query->where("title", "LIKE", "{$filters['title']}%");
        }

        if(isset($filters["author"])) {
            $this->authorService->modifyQueryWhereAuthorLike($query, $filters["author"]);
            $joinAuthor = true; 
        }

        if($joinAuthor) {
            $query->joinAuthor();
        }

        return $query->get();
    }

}
    