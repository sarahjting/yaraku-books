<?php

namespace Tests\Traits;

trait TestsCSV
{
    protected function assertCSVEquals($expected, string $csv): void {
        $this->assertEquals(
            !is_array($expected) ? $this->csvToArray($expected) : $expected, 
            $this->csvToArray($csv)
        );
    }

    protected function csvToArray(string $csv): array {
        $array = explode("\n", $csv);
        return array_map(function($el) {
            return str_getcsv($el);
        }, $array);
    }
}
