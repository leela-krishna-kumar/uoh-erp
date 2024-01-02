<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\QuestionBank;
use App\Models\FeesTypeMaster;
use App\Models\FeesCategory;
use App\Models\Chapter;
use App\Models\ProgramSemesterSection;
use Carbon\Carbon;
use App\User;
use Auth;
use DB;

class FilterController extends Controller
{
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

        $programs = Program::where('faculty_id', $data['faculty'])->where('status', 1)->orderBy('title', 'asc')->get();

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

        $rows = Session::where('status', 1);
        $rows->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });
        // $sessions = $rows->orderBy('id', 'desc')->get();
        $sessions = $rows->orderBy('id', 'asc')->get();

        return response()->json($sessions);
    }

    public function filterSemester(Request $request)
    {
        //
        $data=$request->all();

        $rows = Semester::where('status', 1);
        $rows->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });
        $semesters = $rows->orderBy('id', 'asc')->get();

        return response()->json($semesters);
    }

    public function filterSection(Request $request)
    {
        //
        $data=$request->all();

        $rows = Section::where('status', 1);
        $rows->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($data){
            $query->where('program_id', $data['program']);
            $query->where('semester_id', $data['semester']);
        });
        $sections = $rows->orderBy('title', 'asc')->get();

        return response()->json($sections);
    }

    public function filterSubject(Request $request)
    {
        //
        $data=$request->all();

        $rows = Subject::where('status', 1);
        $rows->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', $data['program']);
        });
        $subjects = $rows->orderBy('code', 'asc')->get();
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

        return response()->json($subjects);
    }
    public function filterQuestionSubject(Request $request)
    {
        //Get Question According to Subjects

        $questions = QuestionBank::where('subject_id',$request->subject_id)->get();
        return response()->json($questions);
    }

    public function getFeeAmount(Request $request)
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
}
