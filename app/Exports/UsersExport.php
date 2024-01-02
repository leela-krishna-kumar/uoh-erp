<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $users = User::get();
        $data = collect();
        foreach ($users as $user) {
            $user->role = isset($user->roles[0]) ? $user->roles[0]->id : '1';
            $data->push([
                'id' => $user->id,
                'staff_id' => $user->staff_id,
                'role' => $user->role,
                'department_id' => $user->department_id, 
                'designation_id' => $user->designation_id, 
                'first_name' => $user->first_name, 
                'last_name' => $user->last_name, 
                'father_name' => $user->father_name, 
                'mother_name' => $user->mother_name, 
                'email' => $user->email, 
                'gender' => $user->gender, 
                'dob' => $user->dob, 
                'joining_date' => $user->joining_date, 
                'ending_date' => $user->ending_date, 
                'phone' => $user->phone, 
                'emergency_phone' => $user->emergency_phone, 
                'marital_status' => $user->marital_status, 
                'blood_group' => $user->blood_group, 
                'national_id' => $user->national_id, 
                'passport_no' => $user->passport_no, 
                'present_province' => $user->present_province, 
                'present_district' => $user->present_district, 
                'present_address' => $user->present_address, 
                'permanent_province' => $user->permanent_province, 
                'permanent_district' => $user->permanent_district, 
                'permanent_address' => $user->permanent_address, 
                'education_level' => $user->education_level, 
                'graduation_academy' => $user->graduation_academy, 
                'year_of_graduation' => $user->year_of_graduation, 
                'graduation_field' => $user->graduation_field, 
                'experience' => $user->experience, 
                'note' => $user->note, 
                'basic_salary' => $user->basic_salary, 
                'contract_type' => $user->contract_type, 
                'work_shift' => $user->work_shift, 
                'salary_type' => $user->salary_type, 
                'epf_no' => $user->epf_no, 
                'bank_account_name' => $user->bank_account_name, 
                'bank_account_no' => $user->bank_account_no, 
                'bank_name' => $user->bank_name, 
                'ifsc_code' => $user->ifsc_code, 
                'bank_brach' => $user->bank_brach, 
                'tin_no' => $user->tin_no, 
                'login' => $user->login, 
                'status' => $user->status,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','staff_id','role', 'department_id', 'designation_id', 'first_name', 'last_name', 'father_name', 'mother_name', 'email', 'gender', 'dob', 'joining_date', 'ending_date', 'phone', 'emergency_phone', 'marital_status', 'blood_group', 'national_id', 'passport_no', 'present_province', 'present_district', 'present_address', 'permanent_province', 'permanent_district', 'permanent_address', 'education_level', 'graduation_academy', 'year_of_graduation', 'graduation_field', 'experience', 'note', 'basic_salary', 'contract_type', 'work_shift', 'salary_type', 'epf_no', 'bank_account_name', 'bank_account_no', 'bank_name', 'ifsc_code', 'bank_branch', 'tin_no', 'login', 'status'];
    }

}
