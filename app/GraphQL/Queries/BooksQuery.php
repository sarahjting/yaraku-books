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
        return Type::listOf(GraphQL::type('book'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Book::all()->toArray();
    }
}