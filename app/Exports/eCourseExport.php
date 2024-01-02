<?php

namespace App\Exports;

use App\Models\ECourse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class eCourseExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $e_courses = ECourse::get();
        $data = collect();
        foreach ($e_courses as $e_course) {
            $data->push([
                'id' => $e_course->id,
                'title' => $e_course->title,
                'semester_id' => $e_course->semester_id,
                'description' => $e_course->description,
                'is_published' => $e_course->is_published,
                'created_by' => $e_course->created_by,
                'duration' => $e_course->duration,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','title','semester_id', 'description','is_published','created_by','duration'];
    }

}
