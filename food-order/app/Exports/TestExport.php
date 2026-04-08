<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Title', 'Value'];
    }

    public function array(): array
    {
        return [
            ['Test Excel', 'Hello from Laravel Excel'],
        ];
    }
}
