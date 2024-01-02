<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $students = Student::where('status', '1')->get();
        $data = collect();
        foreach ($students as $student) {
            $present_address = $student->presentAddress;
            $permanent_address = $student->permanentAddress;
            $data->push([
                'id' => $student->id,
                'first_name' => $student->first_name, 
                'last_name' => $student->last_name,
                'phone' => $student->phone, 
                'email' => $student->email, 
                'student_id' => $student->student_id,
                'gender' => $student->gender, 
                'dob' => $student->dob, 
                'marital_status' => $student->marital_status, 
                'blood_group' => $student->blood_group, 
                'religion' => $student->religion, 
                'admission_date' => $student->admission_date, 
                'admission_no' => $student->admission_no, 
                'roll_no' => $student->roll_no, 
                'distance_from_residence' => $student->distance_from_residence, 
                'phc' => $student->phc, 
                'user_category_id' => $student->user_category_id, 
                'caste' => $student->caste, 
                'seat_type_id' => $student->seat_type_id, 
                'identification_marks' => $student->identification_marks, 
                'academic_year_from' => $student->academic_year_from, 
                'academic_year_to' => $student->academic_year_to, 
                'present_country' => @$present_address->country_id, 
                'present_province' => @$present_address->state_id, 
                'present_district' => @$present_address->city_id, 
                'present_address' => @$present_address->payload, 
                'permanent_country' => @$permanent_address->country_id, 
                'permanent_province' => @$permanent_address->state_id, 
                'permanent_district' => @$permanent_address->city_id, 
                'permanent_address' => @$permanent_address->payload, 
            ]);
        }
        return $data;
        // return Student::get(['id','student_id', 'batch_id', 'program_id', 'admission_date', 'first_name', 'last_name', 
        // 'father_name', 'mother_name', 'father_occupation', 'mother_occupation', 'email', 'present_province', 
        // 'present_district', 'present_address', 'permanent_province', 'permanent_district', 'permanent_address',
        //  'gender', 'dob', 'phone', 'religion', 'marital_status', 'blood_group', 'national_id', 'passport_no', 
        //  'school_name', 'school_exam_id', 'school_graduation_year', 'school_graduation_point', 'collage_name',
        //   'collage_exam_id', 'collage_graduation_year', 'collage_graduation_point', 'login', 'status', 'is_transfer']);
    }


    public function headings(): array
    {
        return ['id','first_name', 'last_name','phone','email','student_id','gender', 'dob','marital_status', 'blood_group', 
        'religion', 'admission_date',  
        'admission_no', 'roll_no', 'distance_from_residence', 'phc','user_category_id','caste', 'seat_type_id', 
        'identification_marks','academic_year_from','academic_year_to','present_country','present_province',
        'present_district', 'present_address', 'permanent_province','permanent_country', 'permanent_district', 'permanent_address'
         ];
    }
    // public function collection()
    // {
    //     $students = Student::where('status', '1')->get();
    //     $data = collect();
    //     foreach ($students as $student) {
    //         $present_address = $student->presentAddress;
    //         $permanent_address = $student->permanentAddress;
    //         $data->push([
    //             'id' => $student->id,
    //             'student_id' => $student->staff_id,
    //             'batch_id' => $student->batch_id,
    //             'program_id' => $student->program_id, 
    //             'admission_date' => $student->admission_date, 
    //             'first_name' => $student->first_name, 
    //             'last_name' => $student->last_name, 
    //             'father_name' => $student->father_name, 
    //             'mother_name' => $student->mother_name, 
    //             'father_occupation' => $student->father_occupation, 
    //             'mother_occupation' => $student->mother_occupation, 
    //             'email' => $student->email, 
    //             'present_province' => @$present_address->state_id, 
    //             'present_district' => @$present_address->city_id, 
    //             'present_address' => @$present_address->payload, 
    //             'permanent_province' => @$permanent_address->state_id, 
    //             'permanent_district' => @$permanent_address->city_id, 
    //             'permanent_address' => @$permanent_address->payload, 
    //             'gender' => $student->gender, 
    //             'dob' => $student->dob, 
    //             'phone' => $student->phone, 
    //             'religion' => $student->religion, 
    //             'marital_status' => $student->marital_status, 
    //             'blood_group' => $student->blood_group, 
    //             'school_name' => $student->school_name, 
    //             'school_exam_id' => $student->school_exam_id, 
    //             'school_graduation_year' => $student->school_graduation_year, 
    //             'school_graduation_point' => $student->school_graduation_point, 
    //             'collage_exam_id' => $student->collage_exam_id, 
    //             'collage_graduation_year' => $student->collage_graduation_year, 
    //             'collage_graduation_point' => $student->collage_graduation_point, 
    //             'login' => $student->login, 
    //             'status' => $student->status, 
    //             'is_transfer' => $student->is_transfer, 

                
    //         ]);
    //     }
    //     return $data;
    //     // return Student::get(['id','student_id', 'batch_id', 'program_id', 'admission_date', 'first_name', 'last_name', 
    //     // 'father_name', 'mother_name', 'father_occupation', 'mother_occupation', 'email', 'present_province', 
    //     // 'present_district', 'present_address', 'permanent_province', 'permanent_district', 'permanent_address',
    //     //  'gender', 'dob', 'phone', 'religion', 'marital_status', 'blood_group', 'national_id', 'passport_no', 
    //     //  'school_name', 'school_exam_id', 'school_graduation_year', 'school_graduation_point', 'collage_name',
    //     //   'collage_exam_id', 'collage_graduation_year', 'collage_graduation_point', 'login', 'status', 'is_transfer']);
    // }


    // public function headings(): array
    // {
    //     return ['id','student_id', 'batch_id', 'program_id', 'admission_date', 'first_name', 'last_name', 
    //     'father_name', 'mother_name', 'father_occupation', 'mother_occupation', 'email', 'present_province',
    //      'present_district', 'present_address', 'permanent_province', 'permanent_district', 'permanent_address'
    //      , 'gender', 'dob', 'phone', 'religion', 'marital_status', 'blood_group', 'school_name', 
    //      'school_exam_id', 'school_graduation_year', 'school_graduation_point', 'collage_name', 
    //      'collage_exam_id', 'collage_graduation_year', 'collage_graduation_point', 'login', 'status',
    //       'is_transfer'];
    // }
}
