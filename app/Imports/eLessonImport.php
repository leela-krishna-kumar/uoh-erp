<?php

namespace App\Imports;

use App\Models\ELesson;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class eLessonImport implements ToCollection, WithHeadingRow
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
            $rules["$key.type"] =  'required';
            $rules["$key.e_section_id"] =  'required';
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.type.required"] = 'The type is required at row.'.($key+2);
            $customMessages["$key.e_section_id.required"] = 'The e_section_id is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $e_lesson = ELesson::find($row['id']);
                if ($e_lesson) {
                    $e_lesson->update(
                      [
                        'title' => $row['title'],
                        'is_published' => $row['is_published'] ?? 0,
                        'type' => $row['type'],
                        'type_id' => $row['type_id'],
                        'e_section_id' => $row['e_section_id'],
                        'created_by' => $row['created_by'] ?? auth()->id(),
                        'short_description' => $row['short_description'],
                        'link' => $row['link'],
                      ]);
                }
            }else{
                $e_lesson = ELesson::create(
                    [
                        'title' => $row['title'],
                        'is_published' => $row['is_published'] ?? 0,
                        'type' => $row['type'],
                        'type_id' => $row['type_id'],
                        'e_section_id' => $row['e_section_id'],
                        'created_by' => $row['created_by'] ?? auth()->id(),
                        'short_description' => $row['short_description'],
                        'link' => $row['link'],
                    ]);
            }
        }
    }
}
