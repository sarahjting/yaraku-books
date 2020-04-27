<?php  

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class AuthorInput extends InputType
{
    protected $attributes = [
        'name' => 'AuthorInput',
        'description' => 'An author'
    ];

    public function fields(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'description' => 'The name of the author',
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}