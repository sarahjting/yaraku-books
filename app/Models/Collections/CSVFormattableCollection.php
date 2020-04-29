<?php

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Interfaces\CSVFormattableInterface;

class CSVFormattableCollection extends Collection implements CSVFormattableInterface
{
    public function toCSV(array $fieldNames): string
    {
        return $this->toCSVHeader($fieldNames) 
            . "\n"
            . $this->toCSVBody($fieldNames);
    }

    public function toCSVHeader(array $fieldNames): string
    {
        return implode(",", $fieldNames);
    }

    public function toCSVBody(array $fieldNames): string
    {
        return $this->map(function($el) use($fieldNames) {
            return implode(",", $el->only($fieldNames));
        })->implode("\n");
    }
}