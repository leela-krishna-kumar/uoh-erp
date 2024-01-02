<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Province;
use App\Models\Country;
use Toastr;

class ProvinceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_province', 1);
        $this->route = 'admin.province';
        $this->view = 'admin.province';
        $this->path = 'province';
        $this->access = 'province';


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

        
        $data['countries'] = Country::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        
        $data['rows'] = Province::orderBy('title', 'asc')->get();

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
        // return $request->all();

        $request->validate([
            'title' => 'required',
            'country' => 'required',
        ]);
        $existRecord = Province::where('title',$request->title)->first();
        if($existRecord){
            Toastr::error(__('msg_title_already_exists'), __('msg_error'));
            return redirect()->back();
        }
        $text = trim($_POST['title']);
        $textAr = explode("\r\n", $text);
        $titles = array_filter($textAr, 'trim');

        foreach ($titles as $title) {
            //check record in DB
            $existName = Province::where('title', $title)->first();
            if(!$existName){
                // Insert Data if name does not exist
                $province = new Province;
                $province->country_id = $request->country;
                $province->slug = Str::slug($title, '-');
                $province->title = $title;
                $province->description = $request->description;
                $province->save();
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
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
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
    public function update(Request $request, Province $province)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|unique:provinces,title,'.$province->id,
            // 'country' => 'required',
        ]);
        // Update Data
        $province->country_id = $request->country;
        $province->title = $request->title;
        $province->description = $request->description;
        $province->status = $request->status;
        $province->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        // Delete Data
        $province->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
