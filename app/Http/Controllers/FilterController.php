<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Batch;
use App\Models\StudentEnroll;
use App\Models\Session;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\QuestionBank;
use App\Models\FeesTypeMaster;
use App\Models\FeesCategory;
use App\Models\Chapter;
use App\Models\ClassRoutine;
use App\Models\ProgramSemesterSection;
use App\Models\HostelRoom;
use Carbon\Carbon;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Toastr;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class FilterController extends Controller
{
    public function filterFaculty(Request $request)
    {
        $data=$request->all();

        $rows = Batch::where('status', 1)->where('faculty_id', $request->faculty);
        $programs = $rows->orderBy('title', 'asc')->get();

        return response()->json($programs);
    }
    public function filterBatch(Request $request)
    {
        $data=$request->all();

        $rows = Program::where('status', 1);
        $rows->with('batches')->whereHas('batches', function ($query) use ($data){
            $query->where('batch_id', $data['batch']);
        });
        $programs = $rows->orderBy('title', 'asc')->get();

        return response()->json($programs);
    }

    public function filterProgram(Request $request)
    {
        //

        $data=$request->all();

        $user = Auth::user();

        // dd($data);

        if(auth()->user()->designation_id == 33){

          // dd('123');

            $program_ids = json_decode(auth()->user()->program_ids);

            $programs = Program::where('faculty_id', $data['faculty'])->whereIn('id', $program_ids)->where('status', 1)->orderBy('title', 'asc')->get();
        }
        elseif(auth()->user()->hasRole('Teacher')){

            // $student_enroll_data = StudentEnroll::where('program_id', $request->program)->where('session_id', $request->session)->where('semester_id', $request->semester)->where('section_id', $request->section)->get();

            $data['program_ids'] = ClassRoutine::where('teacher_id', $user->id)->orderBy('id', 'desc')->pluck('program_id');

            $programs = Program::where('faculty_id', $data['faculty'])->whereIn('id', $data['program_ids']->toArray())->where('status', 1)->get();


        }else{
            $programs = Program::where('faculty_id', $data['faculty'])->where('status', 1)->orderBy('title', 'asc')->get();
        }


        // $programs = Program::where('faculty_id', $data['faculty'])->where('status', 1)->orderBy('title', 'asc')->get();

        return response()->json($programs);
    }
    public function filterStudentData(Request $request)
    {
        //
    //    return $data=$request->all();
        switch($request->type){
            case 'faculty':
                $request['faculty'] = $request->type_id;
               return $this->filterProgram($request);
            break;
            case 'program':
                $request['program'] = $request->type_id;
               return $this->filterSession($request);
            break;
            default:
            return response()->json(['success'=>'No data']);
        }


        $programs = Program::where('faculty_id', $data['faculty'])->where('status', 1)->orderBy('title', 'asc')->get();

        return response()->json($programs);
    }

    public function filterSession(Request $request)
    {
        //
        $data = $request->all();

        // dd($data );

        $user = Auth::user();
        $sessions = Session::where('status', 1);

        // $sessions = $rows->orderBy('id', 'desc')->get();
        if(auth()->user()->hasRole('Teacher')){

            // $student_enroll_data = StudentEnroll::where('program_id', $request->program)->where('session_id', $request->session)->where('semester_id', $request->semester)->where('section_id', $request->section)->get();

            $data['session_ids'] = ClassRoutine::where('teacher_id', $user->id)->orderBy('id', 'desc')->pluck('session_id');

            $sessions->with('programs')->whereHas('programs', function ($query) use ($data){
                $query->where('program_id', $data['program']);
            });

            $sessions = $sessions->whereIn('id', $data['session_ids'])->orderBy('id', 'asc')->get();


        }else{
            $sessions->with('programs')->whereHas('programs', function ($query) use ($data){
                $query->where('program_id', $data['program']);
            });

            $sessions = $sessions->orderBy('id', 'asc')->get();
        }



        return response()->json($sessions);
    }

    public function filterSemester(Request $request)
    {
        //
        $data=$request->all();

        $user = Auth::user();

        $semesters = Semester::where('status', 1);

        if(auth()->user()->hasRole('Teacher'))
        {
        $data['semester_ids'] = ClassRoutine::where('teacher_id', $user->id)->orderBy('id', 'desc')->pluck('semester_id');
        $semesters->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });

        $semesters = $semesters->whereIn('id', $data['semester_ids'])->orderBy('id', 'asc')->get();


        }
        else
        {
        $semesters->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });

        $semesters = $semesters->orderBy('id', 'asc')->get();

        }


        return response()->json($semesters);
    }

    public function filterSection(Request $request)
    {
        //
        $data=$request->all();

        $user = Auth::user();

        $sections = Section::where('status', 1);

        if(auth()->user()->hasRole('Teacher')){

        $data['section_ids'] = ClassRoutine::where('teacher_id', $user->id)->orderBy('id', 'desc')->pluck('section_id');

        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($data){
            $query->where('program_id', $data['program']);
            $query->where('semester_id', $data['semester']);
        });

        $sections = $sections->whereIn('id', $data['section_ids'])->orderBy('title', 'asc')->get();

    }
        else
        {
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($data){
                $query->where('program_id', $data['program']);
                $query->where('semester_id', $data['semester']);
        });
        $sections = $sections->orderBy('title', 'asc')->get();
    }
        return response()->json($sections);
    }

    public function filterState(Request $request)
    {
        $data=$request->all();

    }

    public function filterSubject(Request $request)
    {
        //
        $data=$request->all();
        $user = Auth::user();
        $subjects = Subject::where('status', 1);


        $subjects->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });
        $subjects = $subjects->orderBy('code', 'asc')->get();
        foreach($subjects as $subject){
            if ($subject->regulation_ids){
                foreach ($subject->regulation_ids as $regulation_id){
                    $subject->regulation .= getRegulationName($regulation_id).',';
                }
                rtrim($subject->regulation,',');
            }
        }

        return response()->json($subjects);
    }

    public function filterEnrollSubject(Request $request)
    {
        //
        $data=$request->all();

        $rows = Subject::where('status', 1);
        $rows->with('subjectEnrolls')->whereHas('subjectEnrolls', function ($query) use ($data){
            $query->where('program_id', $data['program']);
            $query->where('semester_id', $data['semester']);
            $query->where('section_id', $data['section']);
        });
        $subjects = $rows->orderBy('code', 'asc')->get();

        return response()->json($subjects);
    }

    public function filterStudentSubject(Request $request)
    {
        //
        $data=$request->all();

        $subjects = DB::table('subjects')->select('subjects.*')->join('student_enroll_subject', 'student_enroll_subject.subject_id', 'subjects.id')->join('student_enrolls', 'student_enrolls.id', 'student_enroll_subject.student_enroll_id')->where('student_enrolls.program_id', $data['program'])->where('student_enrolls.session_id', $data['session'])->where('student_enrolls.semester_id', $data['semester'])->where('student_enrolls.section_id', $data['section'])->where('student_enrolls.status', '1')->where('subjects.status', '1')->orderBy('subjects.code', 'asc')->get();

        return response()->json($subjects);
    }
    public function filterStudent(Request $request)
    {
        // Filter Students by Program
        $students = Student::where('program_id',$request->program)->get();

        return response()->json($students);
    }


    public function filterTecherSubject(Request $request)
    {
       // dd($request->all());
        //
        $data=$request->all();

        // Access Data
        $session = $data['session'];

        $teacher_id = Auth::guard('web')->user()->id;
        $user = User::where('id', $teacher_id)->where('status', '1');
        $user->with('roles')->whereHas('roles', function ($query){
            $query->where('slug', 'super-admin');
        });
        $superAdmin = $user->first();

        // Filter Subject
        $rows = Subject::where('status', '1');
        $rows->with('classes')->whereHas('classes', function ($query) use ($teacher_id, $session, $superAdmin){
            if(isset($session)){
                $query->where('session_id', $session);
            }
            if(!isset($superAdmin)){
                $query->where('teacher_id', $teacher_id);
            }
        });


        $rows->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });

        $subjects = $rows->orderBy('code', 'asc')->get();

        dd('$subjects');


        return response()->json($subjects);
    }
    public function filterQuestionSubject(Request $request)
    {
        //Get Question According to Subjects

        $questions = QuestionBank::where('subject_id',$request->subject_id)->get();
        return response()->json($questions);
    }

 /*   public function getFeeAmount(Request $request)
    {
        if(isset($request->student_id)){
            //Get fee type According to selected student
            $student = Student::find($request->student_id);
            $feesTypeMaster =  FeesTypeMaster::where('faculty_id',$student->faculty_id)->where('program_id',$student->program_id)
            ->where('seat_type_id',$student->seat_type_id)->where('fees_type_id',request()->get('fees_type_id'))->first();
        }else{
            //Get fee type According to selected program
            $feesTypeMaster =  FeesTypeMaster::where('faculty_id',request()->get('faculty_id'))->where('program_id',request()->get('program_id'))
            ->where('seat_type_id',request()->get('seat_type_id'))->where('fees_type_id',request()->get('fees_type_id'))->first();
        }

        if($feesTypeMaster){
            $feeAmount = $feesTypeMaster->amount;
        }else{
            $feesType =  FeesCategory::where('id',request()->get('fees_type_id'))->first();
            $feeAmount = $feesType ? $feesType->amount : 0;
        }
        return response()->json($feeAmount);
    }  */


    public function getFeeCategory(Request $request)
    {
        if(isset($request->student_id)){
            //Get fee type According to selected student
            $student = Student::find($request->student_id);
            $feesTypeMaster =  FeesTypeMaster::where('faculty_id',$student->faculty_id)->where('program_id',$student->program_id)
            ->where('seat_type_id',$student->seat_type_id)->where('fees_type_id',request()->get('fees_type_id'))->first();
        }else{
            //Get fee type According to selected program
            $feesTypeMaster =  FeesTypeMaster::where('faculty_id',request()->get('faculty_id'))->where('program_id',request()->get('program_id'))
            ->where('seat_type_id',request()->get('seat_type_id'))->where('fees_type_id',request()->get('fees_type_id'))->first();
        }

        if($feesTypeMaster){
            $feeAmount = $feesTypeMaster->amount;
        }else{
            $feesType =  FeesCategory::where('id',request()->get('fees_type_id'))->first();
            $feeAmount = $feesType ? $feesType->amount : 0;
        }
        return response()->json($feeAmount);
    }

    public function getFeeAmount(Request $request)
    {
      //  dd($request->student_id);

        $feesTypeMaster = null;

        if(isset($request->student_id)){
            //Get fee type According to selected student
            $student_enroll = StudentEnroll::find($request->student_id);

            $student = Student::find($student_enroll->student_id);

          //  dd( $student );

            $feesTypeMaster =  FeesTypeMaster::where('faculty_id',$student->faculty_id)->where('program_id',$student->program_id)
            ->where('seat_type_id',$student->seat_type_id)->where('fees_type_id',request()->get('fees_type_id'))->first();
        }
        elseif(isset($request->faculty_id)){
            //Get fee type According to selected program
            $feesTypeMaster =  FeesTypeMaster::where('faculty_id',request()->get('faculty_id'))->where('program_id',request()->get('program_id'))
            ->where('seat_type_id',request()->get('seat_type_id'))->where('fees_type_id',request()->get('fees_type_id'))->first();
        }



        if($feesTypeMaster != null){
            $feeAmount = $feesTypeMaster->amount;
        }else{
            $feesType =  FeesCategory::where('id',$request->fees_type_id)->first();
            $feeAmount = $feesType ? $feesType->amount : 0;
        }

      //  dd($request->all());

        return response()->json($feeAmount);
    }





    public function filterTeacher(Request $request){
        $data=$request->all();

        $teacherIds = ProgramSemesterSection::where('program_id', $data['program_id'])->where('semester_id', $data['semester_id'])
                ->where('section_id', $data['section_id'])->pluck('teacher_id')->toArray();
        $teachers = User::role('Teacher')->whereIn('id',$teacherIds)
                ->select('id', 'first_name', 'last_name')
                ->get();

        return response()->json($teachers);
    }

    public function filterChapter(Request $request){
        $chapters = Chapter::where('subject_id', $request->id)->select('id','name')->get();
        return response()->json($chapters);
    }
    public function filterRequisition(Request $request){
        $requisition = Requisition::get();
        return response()->json($requisition);
    }

    public function login(Request $request)
    {
        Log::info($request->all());
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'user_name' => 'required',
                'password' => 'required|min:6|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // User lookup
            $user = User::where('email', $request->user_name)->first();
            $student = Student::where('email', $request->user_name)->first();

            Log::info($student);

            if ($user && Hash::check($request->password, $user->password)) {
                Log::info("Hi1");
                $user->fcm_token = $request->fcm_token;
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'User Login successful',
                    'login_flag' => 0
                ]);
            } else if ($student && Hash::check($request->password, $student->password)) {
                Log::info("Hello");
                $student->fcm_token = $request->fcm_token;
                $student->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Student Login successful',
                    'login_flag' => 1
                ]);
            } else {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Login Failed. Invalid Credentials'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getData(Request $request)
    {
        $filePath = storage_path('college_list.json');
        if (file_exists($filePath)) {
            $jsonContents = file_get_contents($filePath);
            $data = json_decode($jsonContents, true);

            if (isset($request['college_slug'])) {
                $requestedCollegeName = $request['college_slug'];
                foreach ($data as $details) {
                    if ($details['college_slug'] === $requestedCollegeName) {
                        $loginUrl = $details['login_url'];
                        return $details;
                    }
                }
                return response()->json(['error' => 'College not found'], 404);
            } else if (isset($request['college_name'])) {
                $requestedCollegeName = $request['college_name'];
                foreach ($data as $details) {
                    if ($details['college_name'] === $requestedCollegeName) {
                        $loginUrl = $details['login_url'];
                        return $details;
                    }
                }
                return response()->json(['error' => 'College not found'], 404);
            }else {
                return $jsonContents;
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function checkLoginResponse(Request $request)
    {
        Log::info('checking response');
        Log::info($request->all());
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'user_name' => 'required',
                'password' => 'required|min:6|max:255',
            ]);

            // User lookup
            $user = User::where('staff_id', $request->user_name)->first();
            $student = Student::where('roll_no', $request->user_name)->first();
            Log::info($student);

            if ($user && Hash::check($request->password, $user->password)) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'User Login successful',
                    'login_flag' => 0
                ]);
            } elseif ($student && Hash::check($request->password, $student->password)) {
                $student->fcm_token = $request->fcm_token;
                $student->save();
                Log::info($student->fcm_token);
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Student Login successful',
                    'login_flag' => 1
                ]);
            } else {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Login Failed. Invalid Credentials'
                ], 401);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function kaleyraHttp(Request $request)
    {
        $response = Http::withHeaders([
            'api-key' => '<API_KEY>',
        ])->post('https://api.kaleyra.io/v1/<SID>/messages', [
            'to' => '+917285939681',
            'type' => '<TYPE>',
            'sender' => '<SENDER_ID>',
            'body' => 'Hello! This is for testing the kaleyra sms.',
            'template_id' => '<TEMPLATE_ID>',
        ]);

        return $response;
    }

    public function kaleyraCurl(Request $request)
    {
        $url = "https://api.kaleyra.io/v1/<SID>/messages";
        $apiKey = "<API_KEY>";
        $data = [
            'to' => '+917285939681',
            'type' => '<TYPE>',
            'sender' => '<SENDER_ID>',
            'body' => 'Hello! This is for testing the kaleyra sms.',
            'template_id' => '<TEMPLATE_ID>',
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'api-key: ' . $apiKey,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function mobileNotification(Request $request)
    {
        // $validData = $request->validate([
        //     'email' => 'required|email|string',
        //     'password' => 'required|string'
        // ]);
        // $email = $validData['email'];
        // $password = $validData['password'];

        // if (auth()->attempt(['email' => $email, 'password' => $password])) {
        //     $user = auth()->user();
        //     $accessToken = $user->createToken('authToken');
        //     $token = $accessToken->accessToken;
        // }
        $user = User::where('email', 'admin@mail.com')->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key=AAAAo8t_JQI:APA91bGIFOxbWcLpClr6myWH2Bct3bjKvUkH0l9Ucf1iuqcOqtzDz6KbMV5tJha0Fm1Q6NxDfxW-MrtMyupARTJrvK9ioDZOu3ot_Ol8yf83eqobZGqgRoUo1O_WapZdy-c7P977CIKK',
        ];
        $data = [
            "registration_ids" => [
                $user->fcm_token
            ],
            "notification" => [
                "body" => "Venkat testing Announcement",
                "content_available" => true,
                "priority" => "high",
                "subtitle" => "Notification testing by Venkat",
                "Title" => "Venkat Testing"
            ],
            "data" => [
                "priority" => "high",
                "sound" => "app_sound.wav",
                "content_available" => true,
                "bodyText" => "Notification test by venkat",
                "organization" => "venkat testing"
            ]
        ];
        $response = Http::withHeaders($headers)
            ->post('https://fcm.googleapis.com/fcm/send', $data);
       return $response;

        // $response = Http::withHeaders([
        //     'Authorization' => 'key=AIzaSyBwag-_xJ6fGkJFZHpl1CnUpQddp01zP1M',
        //     'Content-Type' => 'application/json',
        // ])->post('https://fcm.googleapis.com/fcm/send', [
        //     'to' => $user->fcm_token,
        //     'notification' => [
        //         'title' => 'Notification testing',
        //         'body' => 'Testing Mobile Notification'
        //     ]
        // ]);
    }

    public function filterHostelRooms(Request $request)
    {
        $data=$request->all();

        $hostel_rooms = HostelRoom::where('hostel_id',$request->hostel)->where('status',1)->select('id','name','hostel_id','room_type_id')->get();

        return response()->json($hostel_rooms);
    }
}
