<?php

namespace App\Imports;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class ProjectImport implements ToCollection, WithHeadingRow
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
            $rules["$key.project_category_id"] =  'required|integer';
            $rules["$key.faculty_id"] =  'required|integer';
            $rules["$key.program_id"] =  'required|integer';
            $rules["$key.session_id"] =  'required|integer';
            $rules["$key.semester_id"] =  'required|integer';
            $rules["$key.section_id"] =  'required|integer';
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.project_category_id.required"] = 'The project_category_id is required at row.'.($key+2);
            $customMessages["$key.faculty_id.required"] = 'The faculty_id is required at row.'.($key+2);
            $customMessages["$key.session_id.required"] = 'The session_id is required at row.'.($key+2);
            $customMessages["$key.semester_id.required"] = 'The semester_id is required at row.'.($key+2);
            $customMessages["$key.section_id.required"] = 'The section_id is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $project = Project::find($row['id']);
                if ($project) {
                    $project->update(
                      [
                          'id' => $row['id'],
                          'title' => $row['title'],
                          'description' => $row['description'],
                          'project_category_id' => $row['project_category_id'],
                          'tags' => $row['tags'],
                          'type' => $row['type'],
                          'type_id' => $row['type_id'],
                          'faculty_id' => $row['faculty_id'],
                          'program_id' => $row['program_id'],
                          'session_id' => $row['session_id'],
                          'semester_id' => $row['semester_id'],
                          'section_id' => $row['section_id'],
                          'status'  => $row['status'],
                      ]);
                }
            }else{
                $project = Project::create(
                    [
                          'title' => $row['title'],
                          'description' => $row['description'],
                          'project_category_id' => $row['project_category_id'],
                          'tags' => $row['tags'],
                          'type' => $row['type'],
                          'type_id' => $row['type_id'],
                          'faculty_id' => $row['faculty_id'],
                          'program_id' => $row['program_id'],
                          'session_id' => $row['session_id'],
                          'semester_id' => $row['semester_id'],
                          'section_id' => $row['section_id'],
                          'status'  => $row['status'],
                    ]);
            }
        }
    }
}
