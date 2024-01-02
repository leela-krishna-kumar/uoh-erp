<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\TransportMember;
use App\Models\TransportRoute;
use App\Models\Grade;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Faculty;
use Carbon\Carbon;
use Toastr;
use Auth;

class TransportStudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('Track Your Vehicle', 1);
        $this->route = 'student.transport-student';
        $this->view = 'student.transport-student';
        $this->path = 'student';
        $this->access = 'transport-member';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkMyBus(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['vehicle'] = TransportMember::where('transportable_id', auth()->id())->first();

        return view($this->view.'.index', $data);
    }
}
