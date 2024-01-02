<?php

namespace App\Imports;

use App\Models\StudentEnroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class StudentEnrollSubjectImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $data = $rows->toArray();
        $rules = [];
        foreach ($data as $key => $item) {
            $rules["$key.student_id"] =  'required|integer';
            $rules["$key.program_id"] =  'required|integer';
            $rules["$key.session_id"] =  'required|integer';
            $rules["$key.semester_id"] =  'required|integer';
            $rules["$key.section_id"] =  'required|integer';
            $rules["$key.status"] =  'required|integer';
            $rules["$key.created_by"] =  'required|integer';
            $customMessages["$key.student_id.required"] = 'The student_id is required at row.'.($key+2);
            $customMessages["$key.program_id.required"] = 'The program_id is required at row.'.($key+2);
            $customMessages["$key.session_id.required"] = 'The session_id is required at row.'.($key+2);
            $customMessages["$key.semester_id.required"] = 'The semester_id is required at row.'.($key+2);
            $customMessages["$key.section_id.required"] = 'The section_id is required at row.'.($key+2);
            $customMessages["$key.status.required"] = 'The status is required at row.'.($key+2);
            $customMessages["$key.created_by.required"] = 'The created_by is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $created_by = $row['created_by'] != null ? $row['created_by'] : auth()->id() ;
            $updated_by = $row['updated_by'] != null ? $row['updated_by'] : auth()->id() ;
            if($row['enroll_id']){
                $studentEnroll = StudentEnroll::find($row['enroll_id']);
                if ($studentEnroll) {
                    $studentEnroll->update(
                      [
                          'id' => $row['enroll_id'],
                          'student_id' => $row['student_id'],
                          'program_id' => $row['program_id'],
                          'session_id' => $row['session_id'],
                          'semester_id' => $row['semester_id'],
                          'section_id' => $row['section_id'],
                          'status'  => $row['status'],
                          'created_by' => $created_by,
                          'updated_by' =>$updated_by,
                      ]);
                      $studentEnroll->subjects()->sync(array_map('strval', explode(',',$row['subject_ids'])));
                }
            }else{
                $studentEnroll =   StudentEnroll::create(
                    [
                        'student_id' => $row['student_id'],
                        'program_id' => $row['program_id'],
                        'session_id' => $row['session_id'],
                        'semester_id' => $row['semester_id'],
                        'section_id' => $row['section_id'],
                        'status'  => $row['status'],
                        'created_by' => $created_by,
                        'updated_by' =>$updated_by,
                    ]);
                    $studentEnroll->subjects()->sync(array_map('strval', explode(',',$row['subject_ids'])));
            }
        }
    }
}
