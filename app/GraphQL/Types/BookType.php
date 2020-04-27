<?php  

namespace App\GraphQL\Types;

use App\Models\Book;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

use GraphQL;

class BookType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Book',
        'description'   => 'A book',
        'model'         => Book::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the book',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the book',
            ],
            'author' => [
                'type' => GraphQL::type('Author'),
                'description' => 'The author of the book',
                'selectable' => false
            ]
        ];
    }
}