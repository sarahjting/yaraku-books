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
            $result[] = $this->toCSVColumn($fieldName);
        }
        $result = $this->csvTranspose($result);
        $result = $this->csvMatrixToRows($result);
        $result = $this->csvRowsToString($result);
        return $result; 
    }

    protected function csvRowsToString($result)
    {
        return implode("\n", $result);
    }

    protected function toCSVColumn($fieldName) {
        return $this->pluck($fieldName)->map(function($el) {
            return '"' . str_replace('"', '""', $el) . '"';
        })->toArray();
    }

    protected function csvMatrixToRows($data) {
        return array_map(function($el) {
            return is_array($el) ? implode(",", $el) : $el;
        }, $data);
    }

    protected function csvTranspose($array) {
        return array_map(null, ...$array);
    }
}