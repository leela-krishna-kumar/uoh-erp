<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\UserBank;
use App\Models\Bank;
use App\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Toastr;

class UserBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('UserBank', 1);
         $this->route = 'admin.user-bank';
         $this->view = 'admin.user-bank';
         $this->path = 'user-bank';
         $this->access = 'user-bank';

         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
         $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

     }
    public function index()
    {
        // return 's';
       try{  
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = UserBank::STATUSES;
        $userBank = UserBank::query();
        if(request()->has('status') && request()->has('status')){
            $userBank->where('status', $request->get('status'));

        }

        $data['rows'] = $userBank->orderBy('id', 'desc')->get();
       
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
        try {
            // $request->validate([
            //     'student_id' => 'required',
            // ]);
                    // Student UserBank
            $payload = [
                'bank_name' => $request->bank_name,
                'type' => $request->type,
                'account_holder_name' => $request->account_holder_name,
                'account_no' => $request->account_no,
                'ifsc_code' => $request->ifsc_code,
                'branch' => $request->branch,
            ];
            $user_bank = new UserBank();
            if (isset($request->student_id)) {
                $user_bank->model_type = Student::class;
                $user_bank->model_id = $request->student_id;
            }else{
                $user_bank->model_type = User::class;
                $user_bank->model_id = $request->user_id;
            }
            $user_bank->payload = $payload;
            $user_bank->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        } catch (\Throwable $th) {
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function show(UserBank $userBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function edit(UserBank $userBank)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = UserBank::STATUSES;
            $data['banks_name'] = Bank::get();
            $data['row'] = $userBank;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserBank $userBank)
    {
        try{
            $payload = [
                'account_holder_name' => $request->account_holder_name,
                'account_no' => $request->account_no,
                'ifsc_code' => $request->ifsc_code,
                'bank_name' => $request->bank_name,
                'branch' => $request->branch,
                'type' => $request->type,
            ];

            $userBank->status = $request->status;
            $userBank->payload = $payload;
            $userBank->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserBank $userBank)
    {
        //
        try{
            if ($userBank) {
                $userBank->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){
            Toastr::error(__('msg_deleted_fail'), __('msg_error'));
            return redirect()->back();
        }
    }
}
