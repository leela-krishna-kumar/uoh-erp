<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Address;
use App\Models\StudentEnroll;
use App\Models\Entrance;
use App\Models\Education;
use App\Models\GuardianDetail;
use App\Models\UserBank;
use App\Models\UserCategory;
use App\Models\Caste;
use App\Models\SeatType;
use App\Models\MotherTongue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class StudentsImport implements ToCollection, WithHeadingRow
{

    protected $faculty_id, $program_id, $batch_id,$session_id,$semester_id, $section_id;

    public function __construct($faculty_id, $program_id, $batch_id,$session_id,$semester_id, $section_id)
    {
        $this->faculty_id = $faculty_id;
        $this->program_id = $program_id;
        $this->batch_id = $batch_id;
        $this->session_id = $session_id;
        $this->semester_id = $semester_id;
        $this->section_id = $section_id;
    }
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
            // $rules["$key.email"] = [
            //     'required',
            //     'email',
            //     Rule::unique('students', 'email')->ignore($item['id'] ? $item['id'] : null, 'id')
            // ];
            $rules["$key.student_id"] =  'required|integer';
            $rules["$key.first_name"] =  'required';
            // $rules["$key.phone"] =  'required';
            $rules["$key.present_province"] =  'nullable';
            $rules["$key.present_district"] =  'nullable';
            $rules["$key.permanent_province"] =  'nullable';
            $rules["$key.permanent_district"] =  'nullable';
         //   $rules["$key.gender"] =  'required';
            // $rules["$key.dob"] =  'required|date';
            $rules["$key.marital_status"] =  'nullable';
            $rules["$key.blood_group"] =  'nullable';
            // $customMessages["$key.email.required"] = 'The email is required at row.'.($key+2);
            $customMessages["$key.student_id.required"] = 'The student id is required at row.'.($key+2);
            $customMessages["$key.student_id.numeric"] = 'The student id must be numeric at row.'.($key+2);
            $customMessages["$key.first_name.required"] = 'The first name is required at row.'.($key+2);
            // $customMessages["$key.phone.required"] = 'The phone is required at row.'.($key+2);
            // $customMessages["$key.dob.date"] = 'The dob must be date at row.'.($key+2);
            // $customMessages["$key.dob.required"] = 'The dob is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
                if(trim($row['scholarship'], 'Â  ') == 'Yes')
                {
                    $scholarship = 1;
                }
                else {
                    $scholarship = 0;
                }

                // if(trim($row['gender'], 'Â  ') == 'Female')
                // {
                //     $gender = 2;
                // } else if(trim($row['gender'], 'Â  ') == 'Male') {
                //     $gender = 1;
                // } else {
                //     $gender = 3;
                // }

                if(trim($row['marital_status'], 'Â  ') == 'single')
                {
                    $marital_status = 1;
                } else if(trim($row['marital_status'], 'Â  ') == 'married') {
                    $marital_status = 2;
                } else if(trim($row['marital_status'], 'Â  ') == 'widowed') {
                    $marital_status = 3;
                } else if(trim($row['marital_status'], 'Â  ') == 'divorced') {
                    $marital_status = 4;
                } else {
                    $marital_status = 5;
                }


                if(trim($row['blood_group'], 'Â  ') == 'A+') {
                    $blood_group = 1;
                } else if(trim($row['blood_group'], 'Â  ') == 'A-') {
                    $blood_group = 2;
                } else if($row['blood_group'] == 'B+') {
                    $blood_group = 3;
                } else if(trim($row['blood_group'], 'Â  ') == 'B-') {
                    $blood_group = 4;
                } else if(trim($row['blood_group'], 'Â  ') == 'AB+') {
                    $blood_group = 5;
                } else if(trim($row['blood_group'], 'Â  ') == 'AB-') {
                    $blood_group = 6;
                } else if(trim($row['blood_group'], 'Â  ') == 'O+') {
                    $blood_group = 7;
                } else if(trim($row['blood_group'], 'Â  ') == 'O-') {
                    $blood_group = 8;
                } else {
                    $blood_group = 8;
                }


                if(trim($row['phc'], 'Â  ') == 'Yes') {
                    $phc = 1;
                } else {
                    $phc = 2;
                }

                if(trim($row['admission_type'], 'Â  ') == 'Lateral') {
                    $admission_type_id = 7;
                } else {
                    $admission_type_id = 6;
                }

                $category = UserCategory::where('name', trim($row['user_category'], 'Â  '))->first();
                if($category)
                {
                    $category_id = $category->id;
                }
                else {
                    $category_id = null;
                }

                $caste = Caste::where('name', trim($row['caste'], 'Â  '))->first();
                if($caste)
                {
                    $caste_id = $caste->id;
                }
                else {
                    $caste_id = '';
                }

                $seat_type = SeatType::where('name', trim($row['seat_type'], 'Â  '))->first();
                if($seat_type) {
                    $seat_type_id = $seat_type->id;
                } else {
                    $seat_type_id = '';
                }

                $mother_tongue = MotherTongue::where('name', trim($row['mother_tongue'], 'Â  '))->first();
                if($mother_tongue)
                {
                    $mother_tongue_id = $mother_tongue->id;
                } else {
                    $mother_tongue_id = '';
                }

                if(trim($row['last_name'], 'Â  ') == null || trim($row['last_name'], 'Â  ') == '')
                {
                    $last_name = '';
                }

                if(trim($row['email'], 'Â  ') == null || trim($row['email'], 'Â  ') == '')
                {
                    $row['email'] = trim($row['roll_no'], 'Â  ') .'@gmail.com';
                }

                $student = Student::create(
                    [
                        'password'      => Hash::make(trim($row['student_id'])),
                        'password_text'     => Crypt::encryptString(trim($row['student_id'])),
                        'first_name' => trim($row['first_name'], 'Â  '), 
                        'last_name' => $last_name,
                        'phone' => trim($row['phone'], 'Â  '), 
                        'email' => trim($row['email'], 'Â  '), 
                        'student_id' => trim($row['student_id']),
                        'gender' => 2, 
                        'dob' => trim($row['dob'], 'Â  '), 
                        'marital_status' => 1, 
                        'blood_group' => $blood_group, 
                        'religion' => trim($row['religion'], 'Â  '), 
                        'admission_date' => trim($row['admission_date'], 'Â  '), 
                        'admission_no' => trim($row['admission_no'], 'Â  '), 
                        'roll_no' => trim($row['roll_no'], 'Â  '), 
                        'distance_from_residence' => trim($row['distance_from_residence'], 'Â  '), 
                        'phc' => $phc,
                        'nationality' => trim($row['nationality'], 'Â  '),
                        'user_category_id' => $category_id, 
                        'caste' => $caste_id, 
                        'admission_type_id' => $admission_type_id, 
                        'seat_type_id' => $seat_type_id,
                        'mother_tongue' => $mother_tongue_id,
                        'identification_marks' => trim($row['identification_marks'], 'Â  '), 
                        'academic_year_from' => trim($row['academic_year_from'], 'Â  '), 
                        'academic_year_to' => trim($row['academic_year_to'], 'Â  '),
                        'faculty_id' => $this->faculty_id,
                        'batch_id' => $this->batch_id,
                        'program_id' => $this->program_id,
                        'session_id' => $this->session_id,
                        'semester_id' => $this->semester_id,
                        'section_id' => $this->section_id,
                        'land_line' => trim($row['land_line'], 'Â  '),
                        'scholarship' => $scholarship,
                        'adhar_card_no' => trim($row['adhar_card_no'], 'Â  '),
                        'ration_card_no' => trim($row['ration_card_no'], 'Â  ')
                    ]);

                    $permanent_address = trim($row['permanent_address'], 'Â  ');

                    $pattern = '/\b\d{6}\b/';
                    preg_match($pattern, $permanent_address, $matches);
                    if (!empty($matches)) {
                        $pincode = $matches[0];
                    } else {
                        $pincode = '';
                    }

                    $permanent_payload = [
                        'address_1' => trim($row['permanent_address'], 'Â  '),
                        'address_2' => null,
                        'pincode' => $pincode
                    ];

                    $permanent_address = Address::create([
                        'payload' => $permanent_payload,
                        'country_id' => 2,
                        'state_id' => 46,
                        'city_id' => 619,
                        'type' => 3,
                        'model_type' => Student::class,
                        'model_id' => $student->id,
                        'is_permanent' => 1,
                    ]);

                    $present_address = trim($row['present_address'], 'Â  ');

                    $pattern = '/\b\d{6}\b/';
                    preg_match($pattern, $present_address, $matches);
                    if (!empty($matches)) {
                        $pincode = $matches[0];
                    } else {
                        $pincode = '';
                    }

                    $present_payload = [
                        'address_1' => trim($row['present_address'], 'Â  '),
                        'address_2' => null,
                        'pincode' => $pincode
                    ];

                    $present_address = Address::create([
                        'payload' => $present_payload,
                        'country_id' => 2,
                        'state_id' => 46,
                        'city_id' => 619,
                        'type' => 3,
                        'model_type' => Student::class,
                        'model_id' => $student->id,
                        'is_permanent' => 0
                    ]);

                    $enroll = StudentEnroll::create([
                        'student_id' => $student->id,
                        'faculty_id' => $this->faculty_id,
                        'batch_id' => $this->batch_id,
                        'program_id' => $this->program_id,
                        'session_id' => $this->session_id,
                        'semester_id' => $this->semester_id,
                        'section_id' => $this->section_id
                    ]);

                    $payload = [
                        "exam_name" => trim($row['entrance_type'], 'Â  '),
                        "hall_ticket_number" => trim($row['hall_ticket_number'], 'Â  '),
                        "rank" => trim($row['rank'], 'Â  ')
                    ];

                    $entrance = Entrance::create([
                        'model_type' => Student::class,
                        'model_id' => $student->id,
                        'payload' => $payload
                    ]);

                    if(trim($row['ssc_marks'], 'Â  ') == null || trim($row['ssc_marks'], 'Â  ') == '')
                    {
                        $ssc_marks = 0;
                    }
                    else{
                        $ssc_marks = trim($row['ssc_marks'], 'Â  ');
                    }

                    if(trim($row['ssc_percentage'], 'Â  ') == null || trim($row['ssc_percentage'], 'Â  ') == '')
                    {
                        $SSC_percentage = 0;
                    }
                    else{
                        $SSC_percentage = trim($row['ssc_percentage'], 'Â  ');
                    }
                    $school_payload = [
                        'school_name' => trim($row['ssc_institution'], 'Â  '),
                        'board' => trim($row['ssc_board'], 'Â  '),
                        'year_of_passing' => trim($row['ssc_year_of_passing'], 'Â  '),
                        'hall_ticket_no' => trim($row['ssc_hall_ticket_no'], 'Â  '),
                        'total_marks' => '1000',
                        'obtain_marks' => $ssc_marks,
                        'gpa' => trim($row['ssc_grade_points'], 'Â  '),
                        'ssc_percentage' => $SSC_percentage
                    ];

                    $school_education = new Education();
                    $school_education->model_id = $student->id;
                    $school_education->model_type = Student::class;
                    $school_education->education_type = 'school';
                    $school_education->payload = $school_payload;
                    $school_education->save();

                    if(trim($row['inter_hall_ticket_no'], 'Â  ') != null && trim($row['inter_hall_ticket_no'], 'Â  ') != '')
                    {


                    if(trim($row['inter_marks'], 'Â  ') == null || trim($row['inter_marks'], 'Â  ') == '')
                    {
                        $inter_marks = 0;
                    }
                    else{
                        $inter_marks = trim($row['inter_marks'], 'Â  ');
                    }

                    if(trim($row['inter_percentage'], 'Â  ') == null || trim($row['inter_percentage'], 'Â  ') == '')
                    {
                        $Inter_percentage = 0;
                    }
                    else{
                        $Inter_percentage = trim($row['inter_percentage'], 'Â  ');
                    }
                        
                        $college_payload = [
                            'collage_name' => trim($row['inter_institution'], 'Â  '),
                            'hall_ticket_no' => trim($row['inter_hall_ticket_no'], 'Â  '),
                            'board' => trim($row['inter_board'], 'Â  '),
                            'collage_graduation_year' => trim($row['inter_year_of_passing'], 'Â  ') . '-04',
                            'total_marks' => 1000,
                            'obtain_marks' => $inter_marks,
                            'collage_graduation_point' => trim($row['inter_grade_points'], 'Â  '),
                            'inter_percentage' => $Inter_percentage
                        ];
                    } else {

                    if(trim($row['diploma_marks'], 'Â  ') == null || trim($row['diploma_marks'], 'Â  ') == '')
                    {
                        $diploma_marks = 0;
                    }
                    else{
                        $diploma_marks = trim($row['diploma_marks'], 'Â  ');
                    }

                    if((trim($row['diploma_percentage'], 'Â  ')) == null || (trim($row['diploma_percentage'], 'Â  ')) == '')
                    {
                        $Diploma_percentage = 0;
                    }
                    else{
                        $Diploma_percentage = trim($row['diploma_percentage'], 'Â  ');
                    }

                        $college_payload = [
                            'collage_name' => trim($row['diploma_institution'], 'Â  '),
                            'hall_ticket_no' => trim($row['diploma_hall_ticket_no'], 'Â  '),
                            'board' => trim($row['diploma_board'], 'Â  '),
                            'collage_graduation_year' => trim($row['diploma_year_of_passing'], 'Â  ') . '-04',
                            'total_marks' => 1000,
                            'obtain_marks' => $diploma_marks,
                            'collage_graduation_point' => trim($row['diploma_grade_points'], 'Â  '),
                            'diploma_percentage' => $Diploma_percentage
                        ];
                    }

                    $college_education = new Education();
                    $college_education->model_id = $student->id;
                    $college_education->model_type = Student::class;
                    $college_education->education_type = 'college';
                    $college_education->payload = $college_payload;
                    $college_education->save();

                    if(trim($row['degree_hall_ticket_no'], 'Â  ') != null && trim($row['degree_hall_ticket_no'], 'Â  ') != '')
                    {

                    if(trim($row['degree_marks'], 'Â  ') == null || trim($row['degree_marks'], 'Â  ') == '')
                    {
                        $degree_marks = 0;
                    }
                    else{
                        $degree_marks = trim($row['degree_marks'], 'Â  ');
                    }

                    if(trim($row['degree_percentage'], 'Â  ') == null || trim($row['degree_percentage'], 'Â  ') == '')
                    {
                        $Degree_percentage = 0;
                    }
                    else{
                        $Degree_percentage = trim($row['degree_percentage'], 'Â  ');
                    }

                        $college_payload = [
                            'collage_name' => trim($row['degree_institution'], 'Â  '),
                            'hall_ticket_no' => trim($row['degree_hall_ticket_no'], 'Â  '),
                            'board' => trim($row['degree_board'], 'Â  '),
                            'collage_graduation_year' => trim($row['degree_year_of_passing'], 'Â  ') . '-04',
                            'total_marks' => 1000,
                            'obtain_marks' => $degree_marks,
                            'collage_graduation_point' => trim($row['degree_grade_points'], 'Â  '),
                            'collage_percentage' => $Degree_percentage
                        ];
    
                        $college_education = new Education();
                        $college_education->model_id = $student->id;
                        $college_education->model_type = Student::class;
                        $college_education->education_type = 'college';
                        $college_education->payload = $college_payload;
                        $college_education->save();
                    }

                    $guardian = new GuardianDetail();
                    $guardian->student_id = $student->id;
                    $guardian->relation_id = 4;
                    $guardian->email = '';
                    $guardian->name = trim($row['father_name'], 'Â  ');
                    $guardian->occupation = trim($row['father_occupation'], 'Â  ');
                    $guardian->annual_income = trim($row['annual_income'], 'Â  ');
                    $guardian->phone = trim($row['father_phone'], 'Â  ');
                    $guardian->save();

                    $guardian = new GuardianDetail();
                    $guardian->student_id = $student->id;
                    $guardian->relation_id = 6;
                    $guardian->email = '';
                    $guardian->name = trim($row['mother_name'], 'Â  ');
                    $guardian->occupation = trim($row['mother_occupation'], 'Â  ');
                    $guardian->phone = trim($row['mother_phone'], 'Â  ');
                    $guardian->save();

                    $bank_payload = [
                        'bank_name' => '',
                        'type' => '',
                        'account_holder_name' => '',
                        'ifsc_code' => '',
                        'branch' => '',
                        'account_no' => trim($row['account_no'], 'Â  ')
                    ];

                    $bank = new UserBank();
                    $bank->model_id = $student->id;
                    $bank->model_type = Student::class;
                    $bank->payload = $bank_payload;
                    $bank->save();

        }
    }
}
