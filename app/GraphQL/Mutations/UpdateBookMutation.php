<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;

use App\Services\BookService; 

class UpdateBookMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateBookMutation'
    ];

    public function type(): Type
    {
        return GraphQL::type("Book");
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id', 
                'type' => Type::nonNull(Type::int()),
            ],
            'book' => [
                'name' => 'book', 
                'type' => Type::nonNull(GraphQL::type('BookInput')),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $bookService = new BookService();
        $book = $bookService->firstWithId($args["id"]);
        if($book === null) return null; 
        
        return $bookService->update($book, $args["book"]);
    }
}