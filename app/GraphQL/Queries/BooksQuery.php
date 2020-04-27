<?php 

namespace App\GraphQL\Queries;

use Closure;
use Arr;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Services\BookService;

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
            'author' => [
                'name' => 'author', 
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $bookService = new BookService;

        $orderBy = $args["orderBy"] ?? "TITLE_ASC";
        $filters = Arr::only($args, ["title", "author"]);

        return $bookService->get($filters, $orderBy);
    }
}