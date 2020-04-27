<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
 
use App\Services\BookService; 

class CreateBookMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateBookMutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Book');
    }

    public function args(): array
    {
        return [
            'book' => [
                'name' => 'book', 
                'type' => Type::nonNull(GraphQL::type('BookInput')),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $bookService = new BookService;
        return $bookService->create($args["book"]);
    }
}