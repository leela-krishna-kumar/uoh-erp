<?php

namespace App\Imports;

use App\Models\ECourse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class eCourseImport implements ToCollection, WithHeadingRow
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
            $rules["$key.description"] =  'required';
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.description.required"] = 'The description is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $e_course = ECourse::find($row['id']);
                if ($e_course) {
                    $e_course->update(
                      [
                      'title' => $row['title'],
                      'semester_id' => $row['semester_id'],
                      'description' => $row['description'],
                      'is_published' => $row['is_published'] ?? 0,
                      'created_by' => $row['created_by'] ?? auth()->id(),
                      'duration' => $row['duration'],
                      ]);
                }
            }else{
                $e_course = ECourse::create(
                    [
                      'title' => $row['title'],
                      'semester_id' => $row['semester_id'],
                      'description' => $row['description'],
                      'is_published' => $row['is_published'] ?? 0,
                      'created_by' => $row['created_by'] ?? auth()->id(),
                      'duration' => $row['duration'],
                    ]);
            }
        }
    }
}
