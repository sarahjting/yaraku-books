<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author_id'
    ];

    public function author() {
        return $this->belongsTo(\App\Models\Author::class);
    }

    public function scopeOrderByAuthor($query, $orderByDirection) {
        $query->orderBy("authors.family_name", $orderByDirection)
            ->orderBy("authors.family_name", $orderByDirection);
    }

    public function scopeJoinAuthor($query) {
        $query->select("books.*")
            ->join("authors", "authors.id", "books.author_id");
    }
}
