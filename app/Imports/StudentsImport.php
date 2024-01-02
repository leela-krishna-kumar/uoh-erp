<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Address;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class StudentsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function collection(Collection $rows)
    // {
    //     Validator::make($rows->toArray(), [
    //         '*.student_id' => 'required|numeric',
    //         '*.batch_id' => 'required|integer',
    //         '*.program_id' => 'required|integer',
    //         '*.admission_date' => 'required|date',
    //         '*.first_name' => 'required',
    //         '*.last_name' => 'required',
    //         '*.email' => 'required',
    //         '*.phone' => 'required',
    //         '*.present_province' => 'nullable|integer',
    //         '*.present_district' => 'nullable|integer',
    //         '*.permanent_province' => 'nullable|integer',
    //         '*.permanent_district' => 'nullable|integer',
    //         '*.gender' => 'required|integer',
    //         '*.dob' => 'required|date',
    //         '*.marital_status' => 'nullable|integer',
    //         '*.blood_group' => 'nullable|integer',
    //         '*.login' => 'required|integer',
    //         '*.status' => 'required|integer',
    //         '*.is_transfer' => 'nullable|integer',
    //     ])->validate();
  

    //     foreach ($rows as $row) {
    //         Student::updateOrCreate(
    //             [
    //             'student_id'     => $row['student_id'],
    //             ],[
    //             'student_id'     => $row['student_id'],
    //             'batch_id'     => $row['batch_id'],
    //             'program_id'     => $row['program_id'],
    //             'admission_date'     => $formattedAdmissionDate,
    //             'first_name'     => $row['first_name'],
    //             'last_name'     => $row['last_name'],
    //             'father_name'     => $row['father_name'],
    //             'mother_name'     => $row['mother_name'],
    //             'father_occupation'     => $row['father_occupation'],
    //             'mother_occupation'     => $row['mother_occupation'],
    //             'email'     => $row['email'],
    //             'password'      => Hash::make($row['student_id']),
    //             'password_text'     => Crypt::encryptString($row['student_id']),
    //             'phone'     => $row['phone'],
    //             'present_province'     => $row['present_province'],
    //             'present_district'     => $row['present_district'],
    //             'present_address'     => $row['present_address'],
    //             'permanent_province'     => $row['permanent_province'],
    //             'permanent_district'     => $row['permanent_district'],
    //             'permanent_address'     => $row['permanent_address'],
    //             'gender'     => $row['gender'],
    //             'dob'     => $formattedDob,
    //             'religion'     => $row['religion'],
    //             'marital_status'     => $row['marital_status'],
    //             'blood_group'     => $row['blood_group'],
    //             'national_id'     => $row['national_id'],
    //             'passport_no'     => $row['passport_no'],
    //             'school_name'     => $row['school_name'],
    //             'school_exam_id'     => $row['school_exam_id'],
    //             'school_graduation_year'     => $row['school_graduation_year'],
    //             'school_graduation_point'     => $row['school_graduation_point'],
    //             'collage_name'     => $row['collage_name'],
    //             'collage_exam_id'     => $row['collage_exam_id'],
    //             'collage_graduation_year'     => $row['collage_graduation_year'],
    //             'collage_graduation_point'     => $row['collage_graduation_point'],
    //             'login'     => $row['login'],
    //             'status'     => $row['status'],
    //             'is_transfer'     => $row['is_transfer'],
    //         ]);
    //     }
    // }
    public function collection(Collection $rows)
    {
        $data = $rows->toArray();
        $rules = [];

        foreach ($data as $key => $item) {
            $rules["$key.email"] = [
                'required',
                'email',
                Rule::unique('students', 'email')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $rules["$key.student_id"] =  'required|integer';
            $rules["$key.first_name"] =  'required';
            $rules["$key.last_name"] =  'required';
            $rules["$key.phone"] =  'required';
            $rules["$key.present_province"] =  'nullable';
            $rules["$key.present_district"] =  'nullable';
            $rules["$key.permanent_province"] =  'nullable';
            $rules["$key.permanent_district"] =  'nullable';
            $rules["$key.gender"] =  'required';
            $rules["$key.dob"] =  'required|date';
            $rules["$key.marital_status"] =  'nullable';
            $rules["$key.blood_group"] =  'nullable';
            $customMessages["$key.email.required"] = 'The email is required at row.'.($key+2);
            $customMessages["$key.student_id.required"] = 'The student id is required at row.'.($key+2);
            $customMessages["$key.student_id.numeric"] = 'The student id must be numeric at row.'.($key+2);
            $customMessages["$key.first_name.required"] = 'The first name is required at row.'.($key+2);
            $customMessages["$key.last_name.required"] = 'The last name is required at row.'.($key+2);
            $customMessages["$key.phone.required"] = 'The phone is required at row.'.($key+2);
            $customMessages["$key.dob.date"] = 'The dob must be date at row.'.($key+2);
            $customMessages["$key.dob.required"] = 'The dob is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $formattedAdmissionDate = Carbon::parse($item['admission_date'])->format('Y-m-d');
            $formattedDob = Carbon::parse($item['dob'])->format('Y-m-d');
            if($row['id']){
                $student = Student::find($row['id']);
                if ($student) {
                    $student->update(
                      [
                        'password'      => Hash::make($row['student_id']),
                        'password_text'     => Crypt::encryptString($row['student_id']),
                        'first_name' => $row['first_name'], 
                        'last_name' => $row['last_name'],
                        'phone' => $row['phone'], 
                        'email' => $row['email'], 
                        'student_id' => $row['student_id'],
                        'gender' => $row['gender'], 
                        'dob' => $formattedDob, 
                        'marital_status' => $row['marital_status'], 
                        'blood_group' => $row['blood_group'], 
                        'religion' => $row['religion'], 
                        'admission_date' => $formattedAdmissionDate, 
                        'admission_no' => $row['admission_no'], 
                        'roll_no' => $row['roll_no'], 
                        'distance_from_residence' => $row['distance_from_residence'], 
                        'phc' => $row['phc'], 
                        'user_category_id' => $row['user_category_id'], 
                        'caste' => $row['caste'], 
                        'seat_type_id' => $row['seat_type_id'], 
                        'identification_marks' => $row['identification_marks'], 
                        'academic_year_from' => $row['academic_year_from'], 
                        'academic_year_to' => $row['academic_year_to'],
                    ]);

                    // dd($row);
                    $permanent_payload = [
                        'address_1' => @$row['permanent_address_1'],
                        'address_2' => @$row['permanent_address_2'],
                        'pincode' => @$row['permanent_pincode'], 
                    ];
                    $present_payload = [
                        'address_1' => @$row['present_address_1'],
                        'address_2' => @$row['present_address_2'],
                        'pincode' => @$row['present_pincode'],
                    ];
                    // Permanent Address
                    $permanent_address = Address::create([
                        'payload' => $permanent_payload,
                        'country_id' => @$row['permanent_country'],
                        'state_id' => $row['permanent_province'],
                        'city_id' => $row['permanent_district'],
                        'type' => @$row['type'],
                        'model_type' => Student::class,
                        'model_id' => $student->id,
                        'is_permanent' => 1,
                    ]);

                    // Present Address
                    $present_address = Address::create([
                        'payload' => $present_payload,
                        'country_id' => @$row['present_country'],
                        'state_id' => $row['present_province'],
                        'city_id' => $row['present_district'],
                        'model_type' => Student::class,
                        'type' => @$row['type'],
                        'model_id' => $student->id,
                        'is_permanent' => 0,
                    ]);
                }
            }else{
               
                $student =   Student::create(
                    [
                        'password'      => Hash::make($row['student_id']),
                        'password_text'     => Crypt::encryptString($row['student_id']),
                        'first_name' => $row['first_name'], 
                        'last_name' => $row['last_name'],
                        'phone' => $row['phone'], 
                        'email' => $row['email'], 
                        'student_id' => $row['student_id'],
                        'gender' => $row['gender'], 
                        'dob' => $formattedDob, 
                        'marital_status' => $row['marital_status'], 
                        'blood_group' => $row['blood_group'], 
                        'religion' => $row['religion'], 
                        'admission_date' => $formattedAdmissionDate, 
                        'admission_no' => $row['admission_no'], 
                        'roll_no' => $row['roll_no'], 
                        'distance_from_residence' => $row['distance_from_residence'], 
                        'phc' => $row['phc'], 
                        'user_category_id' => $row['user_category_id'], 
                        'caste' => $row['caste'], 
                        'seat_type_id' => $row['seat_type_id'], 
                        'identification_marks' => $row['identification_marks'], 
                        'academic_year_from' => $row['academic_year_from'], 
                        'academic_year_to' => $row['academic_year_to'],
                    ]);

                    $permanent_payload = [
                        'address_1' => @$row['permanent_address_1'],
                        'address_2' => @$row['permanent_address_2'],
                        'pincode' => @$row['permanent_pincode'], 
                    ];
                    $present_payload = [
                        'address_1' => @$row['present_address_1'],
                        'address_2' => @$row['present_address_2'],
                        'pincode' => @$row['present_pincode'],
                    ];
                    $present_payload = json_decode($row['present_address'],true);
                    $permanent_payload = json_decode($row['permanent_address'],true);
                    // Permanent Address
                    $permanent_address = Address::create([
                        'payload' => $permanent_payload,
                        'country_id' => @$row['permanent_country'],
                        'state_id' => $row['permanent_province'],
                        'city_id' => $row['permanent_district'],
                        'type' => @$row['type'],
                        'model_type' => Student::class,
                        'model_id' => $student->id,
                        'is_permanent' => 1,
                    ]);
                    // dd($row);

                    // Present Address
                    $present_address = Address::create([
                        'payload' => $present_payload,
                        'country_id' => @$row['present_country'],
                        'state_id' => $row['present_province'],
                        'city_id' => $row['present_district'],
                        'model_type' => Student::class,
                        'type' => @$row['type'],
                        'model_id' => $student->id,
                        'is_permanent' => 0,
                    ]);
            }
        }
    }
}
