<?php 

namespace App\GraphQL\Queries;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Models\Book;

class BooksQuery extends Query
{
    protected $attributes = [
        'name' => 'Books query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Book'));
    }

    public function args(): array
    {
        return [
            'orderBy' => [
                'name' => 'orderBy', 
                'type' => GraphQL::type('BooksOrderBy'),
            ],
            'title' => [
                'name' => 'title', 
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = Book::with("author");
        $joinAuthor = false; 

        if(isset($args["orderBy"])) {
            switch($args["orderBy"]) {
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
        }

        if(isset($args["title"])) {
            $query->where("title", "LIKE", "{$args['title']}%");
        }

        if($joinAuthor) $query->joinAuthor();
        return $query->get();
    }
}