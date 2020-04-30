<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\XMLFormattableInterface;

use App\Models\Traits\FormatsEloquentToXML;

class Author extends Model implements XMLFormattableInterface
{
    use FormatsEloquentToXML;
    
    protected $visible = [
        'id', 'name',
    ];

    protected $fillable = [
        'given_name', 'family_name'
    ];

    public function books()
    {
        return $this->hasMany(\App\Models\Book::class);
    }

    public function getNameAttribute() 
    {
        return "{$this->given_name} {$this->family_name}";
    }

    public function scopeOrderByName($query, $orderByDirection = 'ASC')
    {
        return $query->orderBy('family_name', $orderByDirection)
            ->orderBy('given_name', $orderByDirection);
    }
}
