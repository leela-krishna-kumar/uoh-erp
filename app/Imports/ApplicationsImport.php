<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class ApplicationsImport implements ToCollection, WithHeadingRow
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
            $rules["$key.email"] = [
                'required',
                Rule::unique('applications', 'email')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $rules["$key.registration_no"] =  'required|numeric';
            $rules["$key.program_id"] =  'required|integer';
            $rules["$key.apply_date"] =  'required|date';
            $rules["$key.first_name"] =  'required';
            $rules["$key.last_name"] =  'required';
            $rules["$key.phone"] =  'required';
            $rules["$key.present_province"] =  'nullable|integer';
            $rules["$key.present_district"] =  'nullable|integer';
            $rules["$key.permanent_province"] =  'nullable|integer';
            $rules["$key.permanent_district"] =  'nullable|integer';
            $rules["$key.gender"] =  'required|integer';
            $rules["$key.dob"] =  'required|date';
            $rules["$key.marital_status"] =  'nullable|integer';
            $rules["$key.blood_group"] =  'nullable|integer';
            $customMessages["$key.email.unique"] = 'The email must be unique at row.'.($key+2);
            $customMessages["$key.program_id.required"] = 'The program id is required at row.'.($key+2);
            $customMessages["$key.first_name.required"] = 'The first name is required at row.'.($key+2);
            $customMessages["$key.last_name.required"] = 'The last name is required at row.'.($key+2);
            $customMessages["$key.phone.required"] = 'The phone is required at row.'.($key+2);
            $customMessages["$key.gender.numeric"] = 'The gender is required at row.'.($key+2);
            $customMessages["$key.dob.required"] = 'The dob is required at row.'.($key+2);
            $customMessages["$key.dob.date"] = 'The dob must be date at row.'.($key+2);
        }
       
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        // Validator::make($rows->toArray(), [
        //     '*.registration_no' => 'required|numeric',
        //     '*.program_id' => 'required|integer',
        //     '*.apply_date' => 'required|date',
        //     '*.first_name' => 'required',
        //     '*.last_name' => 'required',
        //     '*.email' => 'required',
        //     '*.phone' => 'required',
        //     '*.present_province' => 'nullable|integer',
        //     '*.present_district' => 'nullable|integer',
        //     '*.permanent_province' => 'nullable|integer',
        //     '*.permanent_district' => 'nullable|integer',
        //     '*.gender' => 'required|integer',
        //     '*.dob' => 'required|date',
        //     '*.marital_status' => 'nullable|integer',
        //     '*.blood_group' => 'nullable|integer',
        // ])->validate();
  

        foreach ($rows as $row) {
            Application::updateOrCreate(
                [
                'registration_no'     => $row['registration_no'],
                ],[
                'registration_no'     => $row['registration_no'],
                'program_id'     => $row['program_id'],
                'apply_date'     => $row['apply_date'],
                'first_name'     => $row['first_name'],
                'last_name'     => $row['last_name'],
                'father_name'     => $row['father_name'],
                'mother_name'     => $row['mother_name'],
                'father_occupation'     => $row['father_occupation'],
                'mother_occupation'     => $row['mother_occupation'],
                'present_province'     => $row['present_province'],
                'present_district'     => $row['present_district'],
                'present_address'     => $row['present_address'],
                'permanent_province'     => $row['permanent_province'],
                'permanent_district'     => $row['permanent_district'],
                'permanent_address'     => $row['permanent_address'],
                'phone'     => $row['phone'],
                'email'     => $row['email'],
                'gender'     => $row['gender'],
                'dob'     => $row['dob'],
                'marital_status'     => $row['marital_status'],
                'blood_group'     => $row['blood_group'],
                'national_id'     => $row['national_id'],
                'passport_no'     => $row['passport_no'],
                'school_name'     => $row['school_name'],
                'school_exam_id'     => $row['school_exam_id'],
                'school_graduation_year'     => $row['school_graduation_year'],
                'school_graduation_point'     => $row['school_graduation_point'],
                'collage_name'     => $row['collage_name'],
                'collage_exam_id'     => $row['collage_exam_id'],
                'collage_graduation_year'     => $row['collage_graduation_year'],
                'collage_graduation_point'     => $row['collage_graduation_point'],
            ]);
        }
    }
}
