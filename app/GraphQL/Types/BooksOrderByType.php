<?php

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\EnumType;

class BooksOrderByType extends EnumType
{
    protected $attributes = [
        'name' => 'BooksOrderBy',
        'description' => 'How to order returned books',
        'values' => [
            'TITLE_ASC' => 'TITLE_ASC',
            'TITLE_DESC' => 'TITLE_DESC',
            'AUTHOR_ASC' => 'AUTHOR_ASC',
            'AUTHOR_DESC' => 'AUTHOR_DESC',
        ],
    ];
}