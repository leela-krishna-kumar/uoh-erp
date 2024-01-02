<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Donar;
use Illuminate\Http\Request;
use Toastr;
class DonarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_donar', 1);
         $this->route = 'admin.donar';
         $this->view = 'admin.donar';
         $this->path = 'donar';
         $this->access = 'donar';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }
    public function index()
    {

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['types'] = Donar::TYPES;
        $donar = Donar::query();
        $data['rows'] = $donar->orderBy('id', 'desc')->get();

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
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['types'] = Donar::TYPES;
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        } 
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
       
        // return $request->all();
        // Insert Data
        $donar = new Donar;
        $donar->donar_type = $request->donar_type;
        $donar->donar_name = $request->donar_name;
        $donar->contact_name = $request->contact_name;
        $donar->email = $request->email;
        $donar->phone = $request->phone;
        $donar->address = $request->address;
        $donar->note = $request->note;
        $donar->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donar  $donar
     * @return \Illuminate\Http\Response
     */
    public function show(Donar $donar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donar  $donar
     * @return \Illuminate\Http\Response
     */
    public function edit(Donar $donar)
    {
        //
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['types'] = Donar::TYPES;
            $data['row'] = $donar;
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
     * @param  \App\Models\Donar  $donar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donar $donar)
    {
        //
        try{
            //    return $request->all();
                $donar->donar_type = $request->donar_type;
                $donar->donar_name = $request->donar_name;
                $donar->contact_name = $request->contact_name;
                $donar->email = $request->email;
                $donar->phone = $request->phone;
                $donar->address = $request->address;
                $donar->note = $request->note;
                $donar->save();
                Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                return redirect('admin/donar')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donar  $donar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donar $donar)
    {
        //
        try{
            $donar;
            if ($donar) {
                 $donar->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
