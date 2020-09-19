<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection/*, WithCustomCsvSettings*/, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return $collection;
    }

    /*public function getCsvSettings(): array
    {
        return [
            'delimiter' => '|',
            'escape_character' => '|',
        ];
    }*/
}
