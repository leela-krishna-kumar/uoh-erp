<?php

namespace App\Exports;

use App\Models\Chapter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChaptersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Chapter::get(['id','subject_id', 'name', 'note', 'start_date', 'end_date', 'status']);
    }


    public function headings(): array
    {
        return ['id','subject_id', 'name', 'note', 'start_date', 'end_date', 'status'];
    }
}
