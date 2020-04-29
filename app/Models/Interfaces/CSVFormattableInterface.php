<?php

namespace App\Models\Interfaces;

interface CSVFormattableInterface {
    public function toCSV(array $fieldNames): string;
    public function toCSVHeader(array $fieldNames): string;
    public function toCSVBody(array $fieldNames): string;
}