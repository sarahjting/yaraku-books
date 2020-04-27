<?php  

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

use GraphQL;

class BookInput extends InputType
{
    protected $attributes = [
        'name' => 'BookInput',
        'description' => 'A book'
    ];

    public function fields(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'description' => 'The title of the book',
                'type' => Type::string(),
            ],
            'author' => [
                'name' => 'author',
                'description' => 'The name of the author',
                'type' => GraphQL::type("AuthorInput"),
            ],
        ];
    }
}