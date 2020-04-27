<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'given_name', 'family_name'
    ];

    public function getNameAttribute() 
    {
        return "{$this->given_name} {$this->family_name}";
    }
}
