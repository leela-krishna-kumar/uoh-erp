<?php

namespace App\Exports;

use App\Models\StudentEnroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentEnrollSubjectExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $studentEnrolls = StudentEnroll::whereHas('subjects')
        ->with('subjects')
        ->get();
        $data = collect();
        foreach ($studentEnrolls as $studentEnroll) {
            $data->push([
                'id' => $studentEnroll->id,
                'student_id' => $studentEnroll->student_id,
                'subject_ids' => $studentEnroll->subjects->pluck('id')->implode(', '),
                'program_id' => $studentEnroll->program_id,
                'session_id' => $studentEnroll->session_id,
                'semester_id' => $studentEnroll->semester_id,
                'section_id' => $studentEnroll->section_id,
                'status'  => $studentEnroll->status,
                'created_by' => $studentEnroll->created_by,
                'updated_by' => $studentEnroll->updated_by,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['enroll_id','student_id','subject_ids', 'program_id', 'session_id', 'semester_id', 'section_id', 'status', 'created_by', 'updated_by',];
    }

}
