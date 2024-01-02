<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Batch;
use App\Models\Semester;
use App\User;
use Illuminate\Http\Request;
use Toastr;
use App\Models\ECourseUser;
use App\Models\ECourse;
use App\Models\ECourseProgress;


class ECourseProgressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProgress(Request $request)
    {
        $e_progress = ECourseProgress::where('student_id', $request->student_id)->where('course_id', $request->course_id)->where('lesson_id', $request->lesson_id)->first();
        if(!$e_progress){
            $e_progress = new ECourseProgress;
            $e_progress->course_id = $request->course_id;
            $e_progress->student_id = $request->student_id;
            $e_progress->lesson_id = $request->lesson_id;
            $e_progress->views = 1;
            $e_progress->save();
        }else{
            $e_progress->views = $e_progress->views + 1;
            $e_progress->save();
        }
        return true;
    }
}
