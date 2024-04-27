<?php

namespace App\Imports;

use App\Models\FundedResearch;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;

class FundedResearchImport implements ToCollection, WithHeadingRow
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
            // $rules["$key.staff_id"] =  'required';
            // $rules["$key.project_category_id"] =  'required|integer';
            // $rules["$key.faculty_id"] =  'required|integer';
            // $rules["$key.program_id"] =  'required|integer';
            // $rules["$key.session_id"] =  'required|integer';
            // $rules["$key.semester_id"] =  'required|integer';
            // $rules["$key.section_id"] =  'required|integer';
            // $customMessages["$key.title.required"] = 'The title is required at row.' . ($key + 2);
            // $customMessages["$key.project_category_id.required"] = 'The project_category_id is required at row.'.($key+2);
            // $customMessages["$key.faculty_id.required"] = 'The faculty_id is required at row.'.($key+2);
            // $customMessages["$key.session_id.required"] = 'The session_id is required at row.'.($key+2);
            // $customMessages["$key.semester_id.required"] = 'The semester_id is required at row.'.($key+2);
            // $customMessages["$key.section_id.required"] = 'The section_id is required at row.'.($key+2);
            $customMessages[] = '';
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $new_reserch = FundedResearch::create(
                [
                    'staff_id' => Auth::user()->staff_id ,
                    'pi_or_co_pi' => $row['pi_or_co_pi'],
                    'funding_agency' => $row['funding_agency'],
                    'sponsored_project' => $row['sponsored_project'],
                    'funds_provided' => $row['funds_provided'],
                    'grant_month_and_year' => $row['grant_month_and_year'],
                    'project_duration' => $row['project_duration'],
                    'type' => $row['type'],
                    'status' => $row['status']
                ]
            );
        }
    }
}
