<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\XMLFormattableInterface;

use App\Models\Traits\FormatsEloquentToXML;

class Author extends Model implements XMLFormattableInterface
{
    use FormatsEloquentToXML;

    protected $fillable = [
        'given_name', 'family_name'
    ];

    public function getNameAttribute() 
    {
        return "{$this->given_name} {$this->family_name}";
    }
}
