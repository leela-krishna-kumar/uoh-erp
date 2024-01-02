<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sports;
use Toastr;

class SportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct()
      {
      // Module Data
      $this->title = trans_choice('module_sports', 1);
      $this->route = 'admin.sports';
      $this->view = 'admin.sports';
      $this->path = 'sports';
      $this->access = 'sports';


      $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete',
      ['only' => ['index','show']]);
      $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
      $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
      }



     
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $sports = Sports::query();
        $data['rows'] = $sports->orderBy('name', 'asc')->get();

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
        //
        $existRecord = Sports::where('name',$request->sports)->first();
        if($existRecord){
            Toastr::error(__('msg_name_already_exists'), __('msg_error'));
            return redirect()->back();
        }
        $sports = new Sports;
        $sports->name = $request->sports;
        $sports->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function show(Sports $sports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function edit(Sports $sports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'sports' => 'required|unique:sports,name,'.$id,
        ]);
         $sports = Sports::find($id);
         $sports->name = $request->sports;
         $sports->save();
         Toastr::success(__('msg_updated_successfully'), __('msg_success'));

         return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    try{

         $sports = Sports::find($id);
         if($sports){
         $sports->delete();
         }
         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }catch(\Exception $e){

         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }
    }
}
