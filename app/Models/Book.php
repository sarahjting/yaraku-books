<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\XMLFormattableInterface;

use App\Models\Traits\FormatsEloquentToXML;

class Book extends Model implements XMLFormattableInterface
{
    use FormatsEloquentToXML;
    
    protected $visible = [
        'id', 'title'
    ];

    protected $fillable = [
        'title', 'author_id'
    ];

    public function author() 
    {
        return $this->belongsTo(\App\Models\Author::class);
    }

    public function scopeOrderByAuthor($query, $orderByDirection) 
    {
        $query->orderBy("authors.family_name", $orderByDirection)
            ->orderBy("authors.given_name", $orderByDirection);
    }

    public function scopeJoinAuthor($query) 
    {
        $query->select("books.*")
            ->join("authors", "authors.id", "books.author_id");
    }

}
