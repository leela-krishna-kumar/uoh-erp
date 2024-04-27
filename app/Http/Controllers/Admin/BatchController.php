<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Batch;
use App\Models\Session;
use App\Models\Regulation;
use App\Models\Faculty;
use App\Models\Student;
use Toastr;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BatchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_batch', 1);
        $this->route = 'admin.batch';
        $this->view = 'admin.batch';
        $this->path = 'batch';
        $this->access = 'batch';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['faculties'] = Faculty::where('status','1')->orderBy('title', 'asc')->get();
        $data['regulations'] =Regulation ::orderBy('name', 'asc')->get();
        $data['rows'] = Batch::orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // try{
            // return $request->all();
            // Field Validation
            $request->validate([
                // 'title' => 'required|max:191|unique:batches,title',
                'faculty_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                ], [
                'end_date.after' => 'The end date must be a date after to the start date.',
            ]);
            $faculty = Faculty::where('id',$request->faculty_id)->select('id','title','slug')->first();
            $bath_title = $faculty->title.' '.Carbon::parse($request->start_date)->format('Y').'-'.Carbon::parse($request->end_date)->format('Y');
            $existBatch = Batch::where('title',$bath_title)->first();
            if($existBatch){
                Toastr::error(__('msg_title_already_exists'), __('msg_error'));
                return redirect()->back();
            }
            //  Insert Data
            $batch = new Batch;
            $batch->faculty_id = $request->faculty_id;
            $batch->regulation_id = $request->regulation_id;
            $batch->title = $bath_title;
            $batch->start_date = $request->start_date;
            $batch->end_date = $request->end_date;
            $batch->save();

            // Sync Program to batch
            // $batch->programs()->attach($request->programs);
            // $batch->programs()->attach($faculty->programs);

            // $startDate = $request->start_date; // Replace with your actual start date
            // $endDate = $request->end_date;   // Replace with your actual end date

            // $period = CarbonPeriod::create($startDate, '1 year', $endDate);

            // $years = [];
            // foreach ($period as $date) {
            //     $years[] = $date->format('Y');
            // }

            // for($i = 1; $i <= count($years); $i++){
            //     if ($i != 1) {
            //         $temp_start_date = Carbon::parse($startDate)->addYears($i)->format('Y-m-d');
            //         $currentYear = Carbon::parse($startDate)->addYears($i)->format('Y');
            //         $nextYear = Carbon::parse($startDate)->addYears($i + 1)->format('Y');
            //     } else {
            //         $currentYear = Carbon::parse($startDate)->format('Y');
            //         $temp_start_date = Carbon::parse($startDate)->format('Y-m-d');
            //         $nextYear = Carbon::parse($startDate)->addYears($i)->format('Y');
            //     }
            //     $session_titles[] = $currentYear . '-' . $nextYear;
            //     // Insert Data
            //     // $session = new Session;
            //     // $session->title = $request->title;
            //     // $session->start_date = $temp_start_date;
            //     // $session->end_date = Carbon::parse($temp_start_date)->addYear(1)->format('Y-m-d');
            //     // $session->current = 1;
            //     // $session->save();

            //     // // Unset current
            //     // Session::where('id', '!=', $session->id)->update([
            //     //     'current' => 0
            //     // ]);

            //     // $session->programs()->attach($request->programs);
            // }


            //NEW CODE By Ankita
            // Sync Session

            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

            $diffInYears = $startDate->diffInYears($endDate);

            $years = range($startDate->year, $endDate->year - 1);

            foreach ($years as $year) {
                $startYear = $year;
                $endYear = $year + 1;

                $start = $startDate->copy()->year($startYear);
                $end = $endDate->copy()->year($endYear);
                // arti changes for restriction on duplicate entry
                $existSession = Session::where('title',$start->format('Y') . '-' . $end->format('Y'))->first();
                if(!$existSession){
                    // Insert Data
                    $session = new Session;
                    $session->title = $start->format('Y') . '-' . $end->format('Y');
                    $session->start_date = $start->format('Y-m-d');
                    $session->end_date = $end->format('Y-m-d');
                    $session->current = 1;
                    $session->save();

                    // Unset current for other sessions
                    Session::where('id', '!=', $session->id)->update([
                        'current' => 0
                    ]);

                    // sync programs to session
                    $session->programs()->attach($request->programs);

                    //NEW CODE By Ankita
                    // Sync Semester
                }
                // end arti changes
                
                
            }
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.edit', $batch->id);

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
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['regulations'] =Regulation ::orderBy('name', 'asc')->get();
        $data['row'] = $batch;
        $data['programs'] = Program::get();
        // $data['programs'] = $batch->programs;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:batches,title,'.$batch->id,
            'start_date' => 'required|date',
            'programs' => 'required',
            'end_date' => 'required|date|after:start_date',
        ], [
            'end_date.after' => 'The end date must be a date after to the start date.',
        ]);
        
        // Update Data
        $batch->title = $request->title;
        $batch->regulation_id = $request->regulation_id;
        $batch->start_date = $request->start_date;
        $batch->end_date = $request->end_date;
        $batch->status = $request->status;
        $batch->save();

        $batch->programs()->sync($request->programs);


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        // Delete Data
        $associated = Student::where('batch_id',$batch->id)->first();
        if($associated){
            Toastr::error(__('msg_cant_deleted'), __('msg_error'));
            return redirect()->back();
        }
        $batch->programs()->detach();
        $batch->delete();
        
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
