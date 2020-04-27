<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;

use App\Services\AuthorService; 

class UpdateAuthorMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateAuthorMutation'
    ];

    public function type(): Type
    {
        return GraphQL::type("Author");
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id', 
                'type' => Type::nonNull(Type::int()),
            ],
            'author' => [
                'name' => 'author', 
                'type' => Type::nonNull(GraphQL::type('AuthorInput')),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $authorService = new AuthorService();
        $author = $authorService->firstWithId($args["id"]);
        if($author === null) return null; 
        
        $authorService->update($author, $args["author"]);
        return $author; 
    }
}