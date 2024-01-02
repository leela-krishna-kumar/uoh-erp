<?php

namespace App\Exports;

use App\Models\ELesson;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class eLessonExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $e_lessons = ELesson::get();
        $data = collect();
        foreach ($e_lessons as $e_lesson) {
            $data->push([
                'id' => $e_lesson->id,
                'title' => $e_lesson->title,
                'is_published' => $e_lesson->is_published,
                'type' => $e_lesson->type,
                'type_id' => $e_lesson->type_id,
                'e_section_id' => $e_lesson->e_section_id,
                'created_by' => $e_lesson->created_by,
                'short_description' => $e_lesson->short_description,
                'link' => $e_lesson->link,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','title','is_published','type', 'type_id', 'image', 'e_section_id', 'created_by','short_description','link'];
    }

}
