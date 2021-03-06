<?php  

namespace App\GraphQL\Types;

use App\Models\Author;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AuthorType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Author',
        'description'   => 'An author',
        'model'         => Author::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the author',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the author',
            ],
            'givenName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The given name of the author',
                'alias' => 'given_name'
            ],
            'familyName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The family name of the author',
                'alias' => 'family_name'
            ],
        ];
    }
}