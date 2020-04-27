<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;

use App\Services\BookService; 

class DeleteBookMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteBookMutation'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id', 
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $bookService = new BookService;
        $book = $bookService->firstWithId($args["id"]);
        return $book && $bookService->delete($book);
    }
}