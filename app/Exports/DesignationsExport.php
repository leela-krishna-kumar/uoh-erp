<?php

namespace App\Exports;

use App\Models\Designation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DesignationsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Designation::get(['id','title', 'filled_positions', 'total_positions', 'job_description']);
    }


    public function headings(): array
    {
        return ['id','title', 'filled_positions', 'total_positions', 'job_description'];
    }
}
