<?php

namespace App\Imports;

use App\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class UsersImport implements ToCollection, WithHeadingRow
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
                'email',
                Rule::unique('users', 'email')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $rules["$key.role"] =  'required|integer';
            $rules["$key.department_id"] =  'required|integer';
            $rules["$key.designation_id"] =  'required|integer';
            $rules["$key.first_name"] =  'required';
            $rules["$key.last_name"] =  'required';
            $rules["$key.phone"] =  'required';
            $rules["$key.present_province"] =  'nullable|integer';
            $rules["$key.present_district"] =  'nullable|integer';
            $rules["$key.permanent_province"] =  'nullable|integer';
            $rules["$key.permanent_district"] =  'nullable|integer';
            $rules["$key.gender"] =  'required|integer';
            $rules["$key.dob"] =  'required|date';
            $rules["$key.joining_date"] =  'required|date';
            $rules["$key.ending_date"] =  'required|date|after_or_equal:joining_date';
            $rules["$key.marital_status"] =  'nullable|integer';
            $rules["$key.blood_group"] =  'nullable|integer';
            $rules["$key.basic_salary"] =  'required|numeric';
            $rules["$key.contract_type"] =  'required|integer';
            $rules["$key.work_shift"] =  'required|integer';
            $rules["$key.salary_type"] =  'required|integer';
            $rules["$key.login"] =  'required|integer';
            $rules["$key.status"] =  'required|integer';
            $customMessages["$key.email.required"] = 'The email is required at row.'.($key+2);
            $customMessages["$key.department_id.required"] = 'The department id is required at row.'.($key+2);
            $customMessages["$key.department_id.numeric"] = 'The department id must be numeric at row.'.($key+2);
            $customMessages["$key.designation_id.required"] = 'The designation id is required at row.'.($key+2);
            $customMessages["$key.designation_id.numeric"] = 'The designation id must be numeric at row.'.($key+2);
            $customMessages["$key.first_name.required"] = 'The first name is required at row.'.($key+2);
            $customMessages["$key.last_name.required"] = 'The last name is required at row.'.($key+2);
            $customMessages["$key.phone.required"] = 'The phone is required at row.'.($key+2);
            $customMessages["$key.dob.date"] = 'The dob must be date at row.'.($key+2);
            $customMessages["$key.dob.required"] = 'The dob is required at row.'.($key+2);
            $customMessages["$key.joining_date.date"] = 'The joining date must be date at row.'.($key+2);
            $customMessages["$key.joining_date.required"] = 'The joining date is required at row.'.($key+2);
            $customMessages["$key.ending_date.date"] = 'The ending date must be date at row.'.($key+2);
            $customMessages["$key.ending_date.required"] = 'The ending date is required at row.'.($key+2);
            $customMessages["$key.ending_date.after_or_equal"] = 'The ending date  must be a date after or equal to joining date at row.'.($key+2);
            $customMessages["$key.basic_salary.required"] = 'The basic salary is required at row.'.($key+2);
            $customMessages["$key.contract_type.required"] = 'The contract type is required at row.'.($key+2);
            $customMessages["$key.work_shift.required"] = 'The work shift is required at row.'.($key+2);
            $customMessages["$key.salary_type.required"] = 'The salary type is required at row.'.($key+2);
            $customMessages["$key.login.required"] = 'The login is required at row.'.($key+2);
            $customMessages["$key.status.required"] = 'The status is required at row.'.($key+2);
            if (Role::where('id','!=',$item['role'])->first()) {
                $customMessages["$key.role"] = $item['role'].' this role id is not exist.'.($key+2);
            }
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $user = User::find($row['id']);
                if ($user) {
                    $user->update(
                      [
                          'staff_id'     => $row['staff_id'],
                          'department_id'    => $row['department_id'],
                          'designation_id'    => $row['designation_id'],
                          'first_name'    => $row['first_name'],
                          'last_name'    => $row['last_name'],
                          'father_name'    => $row['father_name'],
                          'mother_name'    => $row['mother_name'],
                          'email'    => $row['email'],
                          'password'      => Hash::make($row['staff_id']),
                          'password_text'     => Crypt::encryptString($row['staff_id']),
                          'gender'    => $row['gender'],
                          'dob'    => $row['dob'],
                          'joining_date'    => $row['joining_date'],
                          'ending_date'    => $row['ending_date'],
                          'phone'    => $row['phone'],
                          'emergency_phone'    => $row['emergency_phone'],
                          'marital_status'     => $row['marital_status'],
                          'blood_group'     => $row['blood_group'],
                          'national_id'     => $row['national_id'],
                          'passport_no'     => $row['passport_no'],
                          'present_province'     => $row['present_province'],
                          'present_district'     => $row['present_district'],
                          'present_address'     => $row['present_address'],
                          'permanent_province'     => $row['permanent_province'],
                          'permanent_district'     => $row['permanent_district'],
                          'permanent_address'     => $row['permanent_address'],
                          'education_level'    => $row['education_level'],
                          'graduation_academy'    => $row['graduation_academy'],
                          'year_of_graduation'    => $row['year_of_graduation'],
                          'graduation_field'    => $row['graduation_field'],
                          'experience'    => $row['experience'],
                          'note'    => $row['note'],
                          'basic_salary'    => $row['basic_salary'],
                          'contract_type'    => $row['contract_type'],
                          'work_shift'    => $row['work_shift'],
                          'salary_type'    => $row['salary_type'],
                          'epf_no'    => $row['epf_no'],
                          'bank_account_name'    => $row['bank_account_name'],
                          'bank_account_no'    => $row['bank_account_no'],
                          'bank_name'    => $row['bank_name'],
                          'ifsc_code'    => $row['ifsc_code'],
                          'bank_brach'    => $row['bank_branch'],
                          'tin_no'    => $row['tin_no'],
                          'login'    => $row['login'],
                          'status'    => $row['status'],
                      ]);
                    $user->roles()->sync($row['role']);
                }
            }else{
                $user =   User::create(
                    [
                        'staff_id'     => $row['staff_id'],
                        'department_id'    => $row['department_id'],
                        'designation_id'    => $row['designation_id'],
                        'first_name'    => $row['first_name'],
                        'last_name'    => $row['last_name'],
                        'father_name'    => $row['father_name'],
                        'mother_name'    => $row['mother_name'],
                        'email'    => $row['email'],
                        'password'      => Hash::make($row['staff_id']),
                        'password_text'     => Crypt::encryptString($row['staff_id']),
                        'gender'    => $row['gender'],
                        'dob'    => $row['dob'],
                        'joining_date'    => $row['joining_date'],
                        'ending_date'    => $row['ending_date'],
                        'phone'    => $row['phone'],
                        'emergency_phone'    => $row['emergency_phone'],
                        'marital_status'     => $row['marital_status'],
                        'blood_group'     => $row['blood_group'],
                        'national_id'     => $row['national_id'],
                        'passport_no'     => $row['passport_no'],
                        'present_province'     => $row['present_province'],
                        'present_district'     => $row['present_district'],
                        'present_address'     => $row['present_address'],
                        'permanent_province'     => $row['permanent_province'],
                        'permanent_district'     => $row['permanent_district'],
                        'permanent_address'     => $row['permanent_address'],
                        'education_level'    => $row['education_level'],
                        'graduation_academy'    => $row['graduation_academy'],
                        'year_of_graduation'    => $row['year_of_graduation'],
                        'graduation_field'    => $row['graduation_field'],
                        'experience'    => $row['experience'],
                        'note'    => $row['note'],
                        'basic_salary'    => $row['basic_salary'],
                        'contract_type'    => $row['contract_type'],
                        'work_shift'    => $row['work_shift'],
                        'salary_type'    => $row['salary_type'],
                        'epf_no'    => $row['epf_no'],
                        'bank_account_name'    => $row['bank_account_name'],
                        'bank_account_no'    => $row['bank_account_no'],
                        'bank_name'    => $row['bank_name'],
                        'ifsc_code'    => $row['ifsc_code'],
                        'bank_brach'    => $row['bank_branch'],
                        'tin_no'    => $row['tin_no'],
                        'login'    => $row['login'],
                        'status'    => $row['status'],
                    ]);
                $user->roles()->attach($row['role']);
            }
        }
    }
}
