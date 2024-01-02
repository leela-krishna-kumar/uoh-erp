<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuardianDetail;
use App\Models\Student;
use Carbon\Carbon;
use Toastr;
use DB;
use Auth;
use Hash;
use Mail;

class GuardianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        // Module Data
        $this->title = trans_choice('field_guardians_information', 1);
        $this->route = 'admin.student.guardian-detail';
        $this->view = 'admin.student.guardian-detail';
        $this->path = 'guardian-detail';
        $this->access = 'guardian-detail';
    }

    public function index($student_id)
    {

        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['relations'] = Student::RELATION;
            $data['student'] = Student::where('id',$student_id)->select('id')->first();
            $data['rows'] = GuardianDetail::where('student_id',$student_id)->get();    ;
            return view($this->view.'.index', $data);
        } catch(\Exception $e){
    
            Toastr::error(__('msg_error'), __('msg_error'));
    
            return redirect()->back();
        }
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
        // try {
            $request->validate([
                // 'email' => 'required|unique:guardian_details,email',
            ]);
            $guardian_detail = new GuardianDetail();
            $guardian_detail->student_id = $request->student_id;
            $guardian_detail->name = $request->guardian_name;
            $guardian_detail->occupation = $request->occupation;
            $guardian_detail->annual_income = $request->annual_income;
            $guardian_detail->phone = $request->guardian_phone;  
            $guardian_detail->relation_id = $request->relation_id; 
            $guardian_detail->email = $request->email; 
            $guardian_detail->save();
            DB::commit();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        // } catch (\Throwable $th) {
        //     Toastr::error(__('msg_updated_error'), __('msg_error'));

        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,GuardianDetail $guardianDetail)
    {
        // try {
            if (!$guardianDetail) {
                return redirect()->back()->with(__('no_data_found'), __('msg_error'));
            }
            $request->validate([
                // 'email' => 'required|max:191|unique:guardian_details,email,'.$guardianDetail->id,
            ]);
            $guardianDetail->name = $request->guardian_name;
            $guardianDetail->occupation = $request->occupation;
            $guardianDetail->annual_income = $request->annual_income;
            $guardianDetail->phone = $request->guardian_phone;  
            $guardianDetail->relation_id = $request->relation_id; 
            $guardianDetail->email = $request->email; 
            $guardianDetail->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        // } catch (\Throwable $th) {
        //     Toastr::error(__('msg_updated_error'), __('msg_error'));

        //     return redirect()->back();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $guardian_detail = GuardianDetail::find($id);
        $guardian_detail->delete();
        DB::commit();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
