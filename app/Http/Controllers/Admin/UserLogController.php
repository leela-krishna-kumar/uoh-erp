<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use App\User;
use Illuminate\Http\Request;
use Toastr;
use Auth;

class UserLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct()
      {
      // Module Data
      $this->title = trans_choice('module_user_log', 1);
      $this->route = 'admin.user-log';
      $this->view = 'admin.user-log';
      $this->path = 'user-log';
      $this->access = 'user-log';
      $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-print',
      ['only' => ['index','show','outTime']]);
      $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store','outTime']]);
      $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','outTime']]);
      $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
      $this->middleware('permission:'.$this->access.'-print', ['only' => ['tokenPrint']]);
     
    }

    public function index()
    {
        //
       
          $data['title'] = $this->title;
          $data['route'] = $this->route;
          $data['view'] = $this->view;
          $data['path'] = $this->path;
          $data['access'] = $this->access;
          $data['rows'] = UserLog::get();
           
          
           return view($this->view.'.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
              $data['route'] = $this->route;
              $data['title'] = $this->title;
              $data['view'] = $this->view;
              $data['path'] = $this->path;
              $data['access'] = $this->access;
            
             $data['types'] =UserLog::TYPES;
            return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
                $userLogs = new UserLog;
                $userLogs->user_id =auth()->id();
                $userLogs->activity = $request->activity;
                $userLogs->ip_address = $request->ip_address;
                $userLogs->type = $request->type;
                $userLogs->save();
                Toastr::success(__('msg_created_successfully'), __('msg_success'));
                return redirect()->route($this->view.'.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserLog $userLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLog $userLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLog $userLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         try{

         $userLog = UserLog::find($id);
         if($userLog){
         $userLog->delete();
         }

         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }
        catch(\Exception $e){

         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }
         }  
}
