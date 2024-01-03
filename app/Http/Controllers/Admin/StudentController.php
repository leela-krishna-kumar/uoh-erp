<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdmissionType;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Models\StudentRelative;
use App\Models\IdCardSetting;
use App\Models\StudentEnroll;
use App\Models\GuardianDetail;
use App\Models\EnrollSubject;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\MailSetting;
use App\Mail\SendPassword;
use App\Models\StatusType;
use App\Models\StudentGroup;
use App\Models\AddressType;
use App\Models\Caste;
use App\Models\Province;
use App\Models\District;
use App\Models\Entrance;
use App\Models\Address;
use App\Models\UserBank;
use App\Models\Bank;
use App\Models\Relation;
use App\Models\MotherTongue;
use App\User;
use App\Models\Semester;
use App\Models\Document;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Country;
use App\Models\Faculty;
use App\Models\Batch;
use App\Models\Grade;
use App\Models\Fee;
use App\Models\UserCategory;
use App\Models\SeatType;
use App\Models\Education;
use App\Models\ProgramSemesterSection;
use Carbon\Carbon;
use Toastr;
use Auth;
use Hash;
use Mail;
use DB;

class StudentController extends Controller
{
    use FileUploader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_student', 1);
        $this->route = 'admin.student';
        $this->view = 'admin.student';
        $this->path = 'student';
        $this->access = 'student';


        $this->middleware('permission:' . $this->access . '-view|' . $this->access . '-create|' . $this->access . '-edit|' . $this->access . '-delete|' . $this->access . '-card', ['only' => ['index', 'show', 'status', 'sendPassword']]);
        $this->middleware('permission:' . $this->access . '-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:' . $this->access . '-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:' . $this->access . '-delete', ['only' => ['destroy']]);
        $this->middleware('permission:' . $this->access . '-password-print', ['only' => ['printPassword']]);
        $this->middleware('permission:' . $this->access . '-password-change', ['only' => ['passwordChange']]);
        $this->middleware('permission:' . $this->access . '-card', ['only' => ['index', 'card']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //  dd( $request->all());

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['rows'] = [];


        if (!empty($request->faculty) || $request->faculty != null) {
            $data['selected_faculty'] = $faculty = $request->faculty;
        } else {
            $data['selected_faculty'] = $faculty = '0';
        }

        if (!empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = $program = '0';
        }

        if (!empty($request->session) || $request->session != null) {
            $data['selected_session'] = $session = $request->session;
        } else {
            $data['selected_session'] = $session = '0';
        }

        if (!empty($request->semester) || $request->semester != null) {
            $data['selected_semester'] = $semester = $request->semester;
        } else {
            $data['selected_semester'] = $semester = '0';
        }

        if (!empty($request->section) || $request->section != null) {
            $data['selected_section'] = $section = $request->section;
        } else {
            $data['selected_section'] = $section = '0';
        }

        if (!empty($request->status) || $request->status != null) {
            $data['selected_status'] = $status = $request->status;
        } else {
            $data['selected_status'] = '0';
        }


        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();


        if (!empty($request->faculty) && $request->faculty != '0') {
            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }

        if (!empty($request->program) && $request->program != '0') {
            $sessions = Session::where('status', 1);
            $sessions->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
        }

        if (!empty($request->program) && $request->program != '0') {
            $semesters = Semester::where('status', 1);
            $semesters->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
        }

        if (!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0') {
            $sections = Section::where('status', 1);
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester) {
                $query->where('program_id', $program);
                $query->where('semester_id', $semester);
            });
            $data['sections'] = $sections->orderBy('title', 'asc')->get();
        }


        // Student Filter

        // if (!empty($request->program) || !empty($request->semester) &&  !empty($request->faculty)  && !empty($request->session)  && !empty($request->section) || !empty($request->status)) {
        //     $students = Student::query();
        //     if ($faculty != 0 && $faculty != 'all') {
        //         $students->with('program')->whereHas('program', function ($query) use ($faculty) {
        //             $query->where('faculty_id', $faculty);
        //         });
        //     }
        //     if (($session != 0 && $session != 'all') || ($semester != 0 && $semester != 'all') || ($section != 0 && $section != 'all')) {
        //         $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($program, $session, $semester, $section) {
        //             if ($program != 0 && $program != 'all') {
        //                 $query->where('program_id', $program);
        //             }
        //             if ($session != 0 && $session != 'all') {
        //                 $query->where('session_id', $session);
        //             }
        //             if ($semester != 0 && $semester != 'all') {
        //                 $query->where('semester_id', $semester);
        //             }
        //             if ($section != 0 && $section != 'all') {
        //                 $query->where('section_id', $section);
        //             }
        //         });
        //     }

        //     if (!empty($request->status) && $request->status != 'all') {
        //       //  $students->where('status', $status);
        //         // $students->with('statuses')->whereHas('statuses', function ($query) use ($status) {
        //         //     $query->where('status_type_id', $status);
        //         // });
        //     }
        //     $data['rows'] = $students->orderBy('student_id', 'desc')->get();

        //  //   dd($data['rows']);

        //     $data['print'] = IdCardSetting::where('slug', 'student-card')->first();
        // }

       // dd( $faculty, $program, $session, $semester,$section );

        $students = Student::query();

        if($request->faculty != '' || $request->faculty != null){
            $students->where('faculty_id', $faculty);            
        }

        if($request->program != '' || $request->program != null){
            $students->where('program_id', $program);            
        }

        if($request->session != '' || $request->session != null){
            $students->where('session_id', $session);            
        }

        if($request->semester != '' || $request->semester != null){
            $students->where('semester_id', $semester);            
        }

        if($request->section != '' || $request->section != null){
            $students->where('section_id', $section);            
        }

        if($request->status != 'all'){

        if($request->status == '5'){
            $students->where('is_transfer', '1');
        }elseif($request->status == '6'){
            $students->where('is_transfer', '2');
        }else{
            $students->where('status', $request->status);
        }
    }


        $data['rows'] = $students->orderBy('student_id', 'desc')->get();

       // dd( $data['rows']);


        if ($request->id) {
            $students = Student::where('id', 'LIKE', '%' . $request->id . '%')->orWhere('admission_no', 'LIKE', '%' . $request->id . '%');
            $data['rows'] = $students->orderBy('student_id', 'desc')->get();
        }
        return view($this->view . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['address_categories'] = AddressType::get();

        $data['banks_name'] = Bank::orderBy('id', 'asc')->get();
        $data['relations'] = Relation::orderBy('id', 'asc')->get();
        $data['mother_tongues'] = MotherTongue::orderBy('id', 'asc')->get();

        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('id', 'desc')->get();
        $data['faculties'] = Faculty::where('status', '1')->orderBy('id', 'desc')->get();

        $data['programs'] = Program::where('status', '1')->orderBy('id', 'desc')->get();
        $data['sessions'] = Session::where('status', 1)->orderBy('id', 'desc')->get();

        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();
        $role = 6;
        $users = User::where('id', '!=', null);
        $managers =  $users->with('roles')->whereHas('roles', function ($query) use ($role) {
            $query->where('role_id', $role);
        });
        $data['teachers'] = $managers->get();
        $data['user_categories'] = UserCategory::select('id', 'name')->get();
        $data['seat_types'] = SeatType::select('id', 'name')->get();
        $data['castes'] = Caste::select('id', 'name')->get();
        $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();
        $data['countries'] = Country::where('status', '1')->orderBy('title', 'asc')->get();

        return view($this->view . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email',
            'student_id' => 'required|unique:students,student_id',
            'admission_no' => 'required|unique:students,admission_no',
            // 'roll_no' => 'required|unique:students,roll_no',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'academic_year_from' => 'required|date',
            'academic_year_to' => 'required|date|after:academic_year_from',
        ], [
            'email.unique' => 'The email has already been taken. Please choose a different one.',
            'student_id.unique' => 'The Student id has already been taken. Please choose a different one.',
            'admission_no.unique' => 'The admission no has already been taken. Please choose a different one.',
            'roll_no.unique' => 'The roll no has already been taken. Please choose a different one.',
            'academic_year_to.after' => 'Academic year to must be date of after Academic year from.',
        ]);


        // Random Password
        $password = str_random(8);
        // Insert Data

        // try{

        $student = new Student;

        $student->student_id = $request->student_id;
        $student->admission_date = $request->admission_date;
        $student->admission_no = $request->admission_no;
        $student->roll_no = $request->student_id;
        $student->identification_marks = $request->identification_marks;
        $student->distance_from_residence = $request->distance_from_residence;
        $student->phc = $request->phc;
        $student->user_category_id = $request->user_category_id;
        $student->seat_type_id = $request->seat_type_id;
        $student->admission_type_id = $request->admission_type_id;

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->phone = $request->phone;
        $student->password = Hash::make($password);
        $student->password_text = Crypt::encryptString($password);

        $student->academic_year_from = $request->academic_year_from;
        $student->academic_year_to = $request->academic_year_to;

        $student->religion = $request->religion;
        $student->caste = $request->caste;
        $student->mother_tongue = $request->mother_tongue;
        $student->marital_status = $request->marital_status;
        $student->blood_group = $request->blood_group;
        $student->nationality = $request->nationality;

        $student->status = '1';
        $student->created_by = Auth::guard('web')->user()->id;
        $student->save();


        // Attach Status
        $student->statuses()->attach($request->statuses);

        $permanent_payload = [
            'address_1' => $request->permanent_address_1,
            'address_2' => $request->permanent_address_2,
            'pincode' => $request->permanent_pincode,
        ];
        $present_payload = [
            'address_1' => $request->present_address_1,
            'address_2' => $request->present_address_2,
            'pincode' => $request->present_pincode,
        ];

        // Permanent Address
        $permanent_address = Address::create([
            'payload' => $permanent_payload,
            'country_id' => $request->permanent_country,
            'state_id' => $request->permanent_province,
            'city_id' => $request->permanent_district,
            'type' => $request->type,
            'model_type' => Student::class,
            'model_id' => $student->id,
            'is_permanent' => 1,
        ]);

        // Present Address
        $present_address = Address::create([
            'payload' => $present_payload,
            'country_id' => $request->present_country,
            'state_id' => $request->present_province,
            'city_id' => $request->present_district,
            'model_type' => Student::class,
            'type' => $request->type,
            'model_id' => $student->id,
            'is_permanent' => 0,
        ]);


        DB::commit();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->route($this->route . '.edit', [$student->id, 'active' => 'educational']);

        // }
        // catch(\Exception $e){
        //     Toastr::error(__('msg_created_error'), __('msg_error'));


        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $student;

        $data['fees'] = Fee::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->orderBy('id', 'desc')->get();

        $data['bank_details'] = UserBank::where('model_type', Student::class)->where('model_id', $student->id)
            ->orderBy('id', 'desc')->get();

        $data['school_educations'] = Education::where('model_id', $student->id)->where('model_type', Student::class)->where('education_type', 'school')->get();

        $data['college_educations'] = Education::where('model_id', $student->id)->where('model_type', Student::class)->where('education_type', 'college')->get();

        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        // guardian_detail data
        $data['guardian_details'] = GuardianDetail::where('student_id', $student->id)->latest()->get();

        return view($this->view . '.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
        $data['student'] = $student;
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $role = 6;
        $users = User::where('id', '!=', null);
        $managers =  $users->with('roles')->whereHas('roles', function ($query) use ($role) {
            $query->where('role_id', $role);
        });

        $teacherIds = ProgramSemesterSection::where('program_id', $student->program_id)->where('semester_id', $student->semester_id)
            ->where('section_id', $student->section_id)->pluck('teacher_id')->toArray();
        $teachers = User::role('Teacher')->whereIn('id', $teacherIds)
            ->select('id', 'first_name', 'last_name')
            ->get();


        $data['address_categories'] = AddressType::select('id', 'name')->get();
        $data['user_categories'] = UserCategory::select('id', 'name')->get();
        $data['seat_types'] = SeatType::select('id', 'name')->get();
        $data['castes'] = Caste::select('id', 'name')->get();
        $data['countries'] = Country::where('status', '1')->orderBy('title', 'asc')->get();
        $data['provinces'] = Province::where('status', '1')
            ->orderBy('title', 'asc')->get();
        $data['present_districts'] = District::where('status', '1')
            ->where('province_id', $student->present_province)
            ->orderBy('title', 'asc')->get();
        $data['permanent_districts'] = District::where('status', '1')
            ->where('province_id', $student->permanent_province)
            ->orderBy('title', 'asc')->get();

        // Address Data
        $data['present_address'] = $student->presentAddress;
        $data['permanent_address'] = $student->permanentAddress;

        $data['teachers'] = $teachers;
        $data['statuses'] = StatusType::where('status', '1')->get();
        $data['groups'] = StudentGroup::select('id', 'name')->get();

        // Education Data
        $data['school_educations'] = Education::where('model_id', $student->id)->where('model_type', Student::class)->where('education_type', 'school')->get();
        $data['college_educations'] = Education::where('model_id', $student->id)->where('model_type', Student::class)->where('education_type', 'college')->get();
        $data['entrances'] = Entrance::where('model_id', $student->id)->where('model_type', Student::class)->get();

        $data['banks_name'] = Bank::orderBy('id', 'asc')->get();
        $data['relations'] = Relation::orderBy('id', 'asc')->get();
        $data['mother_tongues'] = MotherTongue::orderBy('id', 'asc')->get();

        // ACADEMIC INFORMATION
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        // guardian_detail data
        $data['guardian_details'] = GuardianDetail::where('student_id', $student->id)->latest()->get();

        // Entrance data
        $data['entrance'] = Entrance::where('model_type', Student::class)->where('model_id', $student->id)->first();

        // Banks data
        $data['bank_details'] = UserBank::where('model_type', Student::class)->where('model_id', $student->id)->get();


        //  Student Data
        $data['row'] = $student;

        return view($this->view . '.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {

        // Field Validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            // 'student_id' => 'required|unique:students,student_id,'.$student->id,
            'admission_no' => 'required|unique:students,admission_no,' . $student->id,
            // 'roll_no' => 'required|unique:students,roll_no,'.$student->id,
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
        ], [
            'email.unique' => 'The email has already been taken. Please choose a different one.',
            'student_id.unique' => 'The Student id has already been taken. Please choose a different one.',
            'admission_no.unique' => 'The admission no has already been taken. Please choose a different one.',
            'roll_no.unique' => 'The roll no has already been taken. Please choose a different one.',
        ]);
        // Update Data
        try {
            DB::beginTransaction();

            $student->admission_date = $request->admission_date;
            $student->admission_no = $request->admission_no;
            // $student->roll_no = $request->roll_no;
            $student->identification_marks = $request->identification_marks;
            $student->distance_from_residence = $request->distance_from_residence;
            $student->phc = $request->phc;
            $student->user_category_id = $request->user_category_id;
            $student->seat_type_id = $request->seat_type_id;
            $student->admission_type_id = $request->admission_type_id;
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;

            $student->gender = $request->gender;
            $student->dob = $request->dob;
            $student->phone = $request->phone;
            $student->emergency_phone = $request->emergency_phone;
            $student->status = '1';
            $student->religion = $request->religion;
            $student->caste = $request->caste;
            $student->mother_tongue = $request->mother_tongue;
            $student->marital_status = $request->marital_status;
            $student->blood_group = $request->blood_group;
            $student->nationality = $request->nationality;
            $student->academic_year_from = $request->academic_year_from;
            $student->academic_year_to = $request->academic_year_to;
            $student->photo = $this->updateImage($request, 'photo', $this->path, 300, 300, $student, 'photo');
            $student->signature = $this->updateImage($request, 'signature', $this->path, 300, 100, $student, 'signature');
            $student->updated_by = Auth::guard('web')->user()->id;
            $student->save();


            // Update Status
            $student->statuses()->sync($request->statuses);

            // Permanent Address 
            $permanent_address = $student->permanentAddress;
            if (!$permanent_address) {
                $permanent_payload = [
                    'address_1' => $request->permanent_address_1,
                    'address_2' => $request->permanent_address_2,
                    'pincode' => $request->permanent_pincode,
                ];
                $permanent_address = Address::create([
                    'payload' => $permanent_payload,
                    'country_id' => $request->permanent_country,
                    'state_id' => $request->permanent_province,
                    'city_id' => $request->permanent_district,
                    'type' => $request->type,
                    'model_type' => Student::class,
                    'model_id' => $student->id,
                    'is_permanent' => 1,
                ]);
            } else {
                $permanent_payload = [
                    'address_1' => $request->permanent_address_1,
                    'address_2' => $request->permanent_address_2,
                    'pincode' => $request->permanent_pincode,
                ];
                if ($permanent_address) {
                    $permanent_address->update([
                        'payload' => $permanent_payload,
                        'country_id' => $request->permanent_country,
                        'state_id' => $request->permanent_province,
                        'city_id' => $request->permanent_district,
                    ]);
                }
            }
            // Present Address
            $present_address = $student->presentAddress;
            if (!$present_address) {
                $present_payload = [
                    'address_1' => $request->present_address_1,
                    'address_2' => $request->present_address_2,
                    'pincode' => $request->present_pincode,
                ];
                $present_address = Address::create([
                    'payload' => $present_payload,
                    'country_id' => $request->present_country,
                    'state_id' => $request->present_province,
                    'city_id' => $request->present_district,
                    'model_type' => Student::class,
                    'type' => $request->type,
                    'model_id' => $student->id,
                    'is_permanent' => 0,
                ]);
            } else {
                $present_payload = [
                    'address_1' => $request->present_address_1,
                    'address_2' => $request->present_address_2,
                    'pincode' => $request->present_pincode,
                ];
                if ($present_address) {
                    $present_address->update([
                        'payload' => $present_payload,
                        'country_id' => $request->present_country,
                        'state_id' => $request->present_province,
                        'city_id' => $request->present_district,
                    ]);
                }
            }
            DB::commit();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with(__('msg_success'), __('msg_updated_successfully'));
        } catch (\Exception $e) {

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        // Delete
        $this->deleteMultiMedia($this->path, $student, 'photo');
        $this->deleteMultiMedia($this->path, $student, 'signature');

        // Detach
        $student->relatives()->delete();
        $student->statuses()->detach();
        $student->documents()->detach();
        $student->contents()->detach();
        $student->notices()->detach();
        $student->member()->delete();
        $student->hostelRoom()->delete();
        $student->transport()->delete();
        $student->notes()->delete();

        $student->delete();
        DB::commit();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        // Set Status
        $user = Student::where('id', $id)->firstOrFail();

        if ($user->login == 1) {
            $user->login = 0;
            $user->save();
        } else {
            $user->login = 1;
            $user->save();
        }

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendPassword($id)
    {
        //
        $user = Student::where('id', $id)->firstOrFail();

        $mail = MailSetting::where('status', '1')->first();

        if (isset($mail->sender_email) && isset($mail->sender_name)) {

            $sendTo = $user->email;
            $receiver = $user->first_name . ' ' . $user->last_name;

            // Passing data to email template
            $data['name'] = $user->first_name . ' ' . $user->first_name;
            $data['student_id'] = $user->student_id;
            $data['email'] = $user->email;
            $data['password'] = Crypt::decryptString($user->password_text);

            // Mail Information
            $data['subject'] = __('msg_your_login_credentials');
            $data['from'] = $mail->sender_email;
            $data['sender'] = $mail->sender_name;


            // Send Mail
            Mail::to($sendTo, $receiver)->send(new SendPassword($data));


            Toastr::success(__('msg_sent_successfully'), __('msg_success'));
        } else {
            Toastr::success(__('msg_receiver_not_found'), __('msg_success'));
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printPassword($id)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $data['row'] = Student::where('id', $id)->firstOrFail();

        return view($this->view . '.password-print', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function passwordChange(Request $request)
    {
        // Field Validation
        $request->validate([
            'student_id' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Update Data
        $student = Student::findOrFail($request->student_id);
        $student->password = Hash::make($request->password);
        $student->password_text = Crypt::encryptString($request->password);
        $student->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function card($id)
    {
        //
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['path']      = $this->path;

        $data['row'] = Student::findOrFail($id);

        $data['print'] = IdCardSetting::where('slug', 'student-card')->firstOrFail();

        return view($this->view . '.card', $data);
    }
}
