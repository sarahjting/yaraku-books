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
        $result = [];
        foreach($fieldNames as $fieldName) {
            $result[] = $this->pluck($fieldName)->map(function($el) {
                return '"' . str_replace('"', '""', $el) . '"';
            })->toArray();
        }
        return implode("\n", array_map(function($el) {
            return is_array($el) ? implode(",", $el) : $el;
        }, array_map(null, ...$result)));
    }
}