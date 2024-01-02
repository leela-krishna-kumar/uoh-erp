<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostelRoomType;
use App\Models\FeesCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Toastr;

class HostelRoomTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_room_type', 1);
        $this->route = 'admin.room-type';
        $this->view = 'admin.room-type';
        $this->path = 'room-type';
        $this->access = 'room-type';


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

        $department = Department::where('title','Hostel')->first();
        $data['rows'] = HostelRoomType::orderBy('title', 'asc')->get();
        $data['feesCategories'] = FeesCategory::where('department_id',@$department->id)->get();
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
            'title' => 'required|max:191|unique:hostel_room_types,title',
            'fee_id' => 'required|numeric',
        ]);

        $text = trim($_POST['title']);
        $textAr = explode("\r\n", $text);
        $titles = array_filter($textAr, 'trim');

        foreach ($titles as $title) {
            //check record in DB
            $existTitle = HostelRoomType::where('title', $title)->first();
            if(!$existTitle){
                // Insert Data if title does not exist
                $hostelRoomType = new HostelRoomType;
                $hostelRoomType->title = $title;
                $hostelRoomType->fee_id = $request->fee_id;
                $hostelRoomType->description = $request->description;
                $hostelRoomType->save();
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
    public function show(HostelRoomType $hostelRoomType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HostelRoomType $hostelRoomType)
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
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:hostel_room_types,title,'.$id,
            'fee_id' => 'required|numeric',
        ]);

        // Update Data
        $hostelRoomType = HostelRoomType::findOrFail($id);
        $hostelRoomType->title = $request->title;
        $hostelRoomType->fee_id = $request->fee_id;
        $hostelRoomType->description = $request->description;
        $hostelRoomType->status = $request->status;
        $hostelRoomType->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Data
        $hostelRoomType = HostelRoomType::findOrFail($id);
        $hostelRoomType->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
