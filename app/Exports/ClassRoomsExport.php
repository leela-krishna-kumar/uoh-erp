<?php

namespace App\Exports;

use App\Models\ClassRoom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassRoomsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ClassRoom::get(['id','title', 'floor', 'capacity', 'type']);
    }


    public function headings(): array
    {
        return ['id','title', 'floor', 'capacity', 'type'];
    }
}
