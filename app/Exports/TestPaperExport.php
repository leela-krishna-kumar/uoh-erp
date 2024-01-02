<?php

namespace App\Exports;

use App\Models\TestPaper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestPaperExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $test_papers = TestPaper::get();
        $data = collect();
        foreach ($test_papers as $test_paper) {
            $data->push([
                'id' => $test_paper->id,
                'title' => $test_paper->title,
                'faculty_id' => $test_paper->faculty_id,
                'program_id' => $test_paper->program_id,
                'batch_id' => $test_paper->batch_id,
                'session_id' => $test_paper->session_id,
                'semester_id' => $test_paper->semester_id,
                'section_id' => $test_paper->section_id,
                'subject_id' => $test_paper->subject_id,
                'started_from' => $test_paper->started_from,
                'duration' => $test_paper->duration,
                'disclaimer' => $test_paper->disclaimer,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','title','faculty_id','program_id','batch_id','session_id','semester_id','section_id','subject_id','started_from','duration','disclaimer'];
    }

}
