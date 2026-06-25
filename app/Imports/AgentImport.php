<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class AgentImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Only collect — do not save. Controller will handle saving.
    }
}
