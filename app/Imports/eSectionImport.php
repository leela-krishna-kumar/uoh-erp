<?php

namespace App\Imports;

use App\Models\ESection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class eSectionImport implements ToCollection, WithHeadingRow
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
            $rules["$key.e_course_id"] =  'required';
            $rules["$key.created_by"] =  'required';
            $rules["$key.sequence"] =  'required';
            $rules["$key.short_description"] =  'required';
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.e_course_id.required"] = 'The e_course_id is required at row.'.($key+2);
            $customMessages["$key.created_by.required"] = 'The created_by is required at row.'.($key+2);
            $customMessages["$key.sequence.required"] = 'The sequence is required at row.'.($key+2);
            $customMessages["$key.short_description.required"] = 'The short_description is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $e_lesson = ESection::find($row['id']);
                if ($e_lesson) {
                    $e_lesson->update(
                      [
                        'title' => $row['title'],
                        'e_course_id' => $row['e_course_id'],
                        'created_by' => $row['created_by'] ?? auth()->id(),
                        'sequence' => $row['sequence'],
                        'short_description' => $row['short_description'],
                      ]);
                }
            }else{
                $e_lesson = ESection::create(
                    [
                        'title' => $row['title'],
                        'e_course_id' => $row['e_course_id'],
                        'created_by' => $row['created_by'] ?? auth()->id(),
                        'sequence' => $row['sequence'],
                        'short_description' => $row['short_description'],
                    ]);
            }
        }
    }
}
