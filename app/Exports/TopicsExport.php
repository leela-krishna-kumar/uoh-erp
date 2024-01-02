<?php

namespace App\Exports;

use App\Models\Topic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopicsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Topic::get(['id','chapter_id', 'name', 'note', 'start_date', 'end_date', 'status']);
    }


    public function headings(): array
    {
        return ['id','chapter_id', 'name', 'note', 'start_date', 'end_date', 'status'];
    }
}
