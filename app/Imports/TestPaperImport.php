<?php

namespace App\Imports;

use App\Models\TestPaper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class TestPaperImport implements ToCollection, WithHeadingRow
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
            $rules["$key.title"] =  'required';
            $customMessages["$key.title.required"] = 'The Title is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $test_paper = TestPaper::find($row['id']);
                if ($test_paper) {
                    $test_paper->update(
                      [
                        'title' => $row['title'],
                        'faculty_id' => $row['faculty_id'],
                        'program_id' => $row['program_id'],
                        'batch_id' => $row['batch_id'],
                        'session_id' => $row['session_id'],
                        'semester_id' => $row['semester_id'],
                        'section_id' => $row['section_id'],
                        'subject_id' => $row['subject_id'],
                        'started_from' => $row['started_from'],
                        'duration' => $row['duration'],
                        'disclaimer' => $row['disclaimer'],
                      ]);
                }
            }else{
                $test_paper = TestPaper::create(
                    [
                        'title' => $row['title'],
                        'faculty_id' => $row['faculty_id'],
                        'program_id' => $row['program_id'],
                        'batch_id' => $row['batch_id'],
                        'session_id' => $row['session_id'],
                        'semester_id' => $row['semester_id'],
                        'section_id' => $row['section_id'],
                        'subject_id' => $row['subject_id'],
                        'started_from' => $row['started_from'],
                        'duration' => $row['duration'],
                        'disclaimer' => $row['disclaimer'],
                    ]);
            }
        }
    }
}
