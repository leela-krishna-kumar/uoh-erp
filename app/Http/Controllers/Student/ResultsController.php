<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamRoutine;
use App\Models\ExamType;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultsController extends Controller
{
    //
    //  $posts = Post::all();
        // return view('results.index', compact('posts'));

        public function __construct()
        {
            // Module Data
            $this->title = 'Exam Results';
            $this->route = 'student.results';
            $this->student_route = 'student.student-results';
            $this->view = 'student.results';
            $this->path = 'results';
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function studentResults(Request $request)
        {
            // return $request->all();
            //
            $data['title']     = $this->title;
            $data['route']     = $this->route;
            $data['view']      = $this->view;
            $data['path']      = $this->path;
            $data['student_route']      = $this->student_route;


            if(!empty($request->type) || $request->type != null){
                $data['selected_type'] = $type = $request->type;
            }
            else{
                $data['selected_type'] = '0';
            }


            $data['types'] = ExamType::where('status', '1')->orderBy('title', 'asc')->get();
            $session = Session::where('status', '1')->where('current', '1')->first();

            if(isset($session)){
                $enroll = StudentEnroll::where('student_id', Auth::guard('student')->user()->id)
                                ->where('session_id', $session->id)
                                ->where('status', '1')
                                ->first();
            }

            if(isset($enroll) && isset($session) && isset($type)){

                $data['rows'] = Exam::where('student_enroll_id',$enroll->id)->where('exam_type_id',$type)->get();

            // dd($data['rows']);
            }

            return view($this->view.'.index', $data);
        }


}
