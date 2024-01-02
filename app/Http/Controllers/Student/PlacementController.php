<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use Illuminate\Http\Request;
use App\Models\PlacedStudent;
use Carbon\Carbon;
use Toastr;
use Auth;
class PlacementController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_upcoming_placement', 2);
        $this->route = 'student.placements';
        $this->view = 'student.placement';
        $this->path = 'placement';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['rows'] = Placement::where('deadline_date', '>=' , now()->format('Y-m-d'))->orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apply(Request $request) {
        try {
            $placement = Placement::where('id', $request->placement_id)->first();
            if (
                $request->high_school < $placement->criteria_description['high_school'] ||
                $request->higher_secondary < $placement->criteria_description['higher_secondary'] ||
                $request->aggregate < $placement->criteria_description['aggregate']
            ) {
                return back()->with('error', 'You are not eligible for this placement');
            }
            $criteria_description = [
                'high_school' => $request->high_school,
                'higher_secondary' => $request->higher_secondary,
                'aggregate' => $request->aggregate,
            ];
            $placedStudent = new PlacedStudent();
            $placedStudent->placement_id = $placement->id;
            $placedStudent->criteria_description = $criteria_description;
            $placedStudent->student_id = Auth::guard('student')->id();
            $placedStudent->save();
            // return  $placedStudent;
            return back()->with('success','Applied Successfully');
        }catch(Exception $e){
            return back()->with('error', $e);
        }
   }
}
