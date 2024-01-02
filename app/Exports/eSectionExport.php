<?php

namespace App\Exports;

use App\Models\ESection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class eSectionExport  implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $e_sections = ESection::get();
        $data = collect();
        foreach ($e_sections as $e_section) {
            $data->push([
                'id' => $e_section->id,
                'title' => $e_section->title,
                'e_course_id' => $e_section->e_course_id,
                'created_by' => $e_section->created_by ?? auth()->id(),
                'sequence' => $e_section->sequence,
                'short_description' => $e_section->short_description,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','title','e_course_id','created_by', 'sequence', 'short_description'];
    }

}
