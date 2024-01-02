<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CollegeBank;
use App\Models\Bank;
use Illuminate\Http\Request;
use Toastr;

class CollegeBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_college_banks', 1);
         $this->route = 'admin.college-bank';
         $this->view = 'admin.college-bank';
         $this->path = 'college-bank';
         $this->access = 'college-bank';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
         $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

     }
    public function index()
    {
        //
        // try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $collegeBank = CollegeBank::query();
  
            if(request()->has('status') && request()->has('status')){
                $collegeBank->where('status', $request->get('status'));
            }
            $data['rows'] = $collegeBank->orderBy('id', 'desc')->get();
           
            return view($this->view.'.index', $data);
        // } catch(\Exception $e){
    
        //     Toastr::error(__('msg_error'), __('msg_error'));
    
        //     return redirect()->back();
        // } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            
           
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['type'] = CollegeBank::TYPES;
            $data['banks'] = Bank::get();
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        } 
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
               
            ]);

            // Insert Data
            $collegeBank = new CollegeBank;
            $collegeBank->bank_id = $request->bank_id;
            $collegeBank->ifsc = $request->ifsc;
            $collegeBank->account_holder_name = $request->account_holder_name;
            $collegeBank->account_no = $request->account_no;
            $collegeBank->type = $request->type;
            $collegeBank->branch = $request->branch;
            $collegeBank->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect('admin/college-bank');
        // } catch(\Exception $e){

        //     Toastr::error(__('msg_updated_error'), __('msg_error'));

        //     return redirect()->back();
        // } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollegeBank  $collegeBank
     * @return \Illuminate\Http\Response
     */
    public function show(CollegeBank $collegeBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollegeBank  $collegeBank
     * @return \Illuminate\Http\Response
     */
    public function edit(CollegeBank $collegeBank)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['banks'] = Bank::get();
            $data['row'] = $collegeBank;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        } 
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeBank  $collegeBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CollegeBank $collegeBank)
    {
        //
    try{
        // Field Validation
        $collegeBank->bank_id = $request->bank_id;
        $collegeBank->ifsc = $request->ifsc;
        $collegeBank->type = $request->type;
        $collegeBank->account_holder_name = $request->account_holder_name;
        $collegeBank->account_no = $request->account_no;
        $collegeBank->branch = $request->branch;
        $collegeBank->save();
        
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/college-bank')->with( __('msg_success'), __('msg_updated_successfully'));
    }
    catch(\Exception $e){

        Toastr::error(__('msg_updated_error'), __('msg_error'));

        return redirect()->back();
    }        
}

/**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\CollegeBank  $collegeBank
 * @return \Illuminate\Http\Response
 */
public function destroy(CollegeBank $collegeBank)
{

    try{
        $collegeBank;
        if ($collegeBank) {
             $collegeBank->delete();
        }
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        return redirect()->back();
    }catch(\Exception $e){

        Toastr::error(__('msg_deleted_fail'), __('msg_error'));

        return redirect()->back();
    }
}
}

