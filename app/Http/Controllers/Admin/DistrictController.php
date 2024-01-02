<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use Toastr;

class DistrictController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_district', 1);
        $this->route = 'admin.district';
        $this->view = 'admin.district';
        $this->path = 'district';
        $this->access = 'district';


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

        $data['provinces'] = Province::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        $data['rows'] = District::orderBy('title', 'asc')->get();

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
        // Field Validation
        $request->validate([
            'province' => 'required',
            'title' => 'required',
        ]);
        $existRecord = District::where('title',$request->title)->first();
        if($existRecord){
            Toastr::error(__('msg_title_already_exists'), __('msg_error'));
            return redirect()->back();
        }
        $text = trim($_POST['title']);
        $textAr = explode("\r\n", $text);
        $titles = array_filter($textAr, 'trim');

        foreach ($titles as $title) {
            //check record in DB
            $existName = District::where('title', $title)->first();
            if(!$existName){
                // Insert Data if name does not exist
                $district = new District;
                $district->province_id = $request->province;
                $district->title = $title;
                $district->description = $request->description;
                $district->save();

            }
        }

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
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
    public function update(Request $request, District $district)
    {
        // Field Validation
        $request->validate([
            'province' => 'required',
            'title' => 'required|unique:student_report_categories,title,'.$id,
        ]);


        // Update Data
        $district->province_id = $request->province;
        $district->title = $request->title;
        $district->description = $request->description;
        $district->status = $request->status;
        $district->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        // Delete Data
        $district->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
