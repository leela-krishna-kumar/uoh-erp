<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;
use Toastr;
class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_scholarship_provider', 1);
         $this->route = 'admin.donor';
         $this->view = 'admin.donor';
         $this->path = 'donor';
         $this->access = 'donor';
 
 
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
        $data['types'] = Donor::TYPES;
        $donor= Donor::query();
        $data['rows'] = $donor->orderBy('id', 'desc')->get();

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
            $data['types'] = Donor::TYPES;
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
        $existRecord = Donor::where('donor_name',$request->donor_name)->first();
        if($existRecord){
            Toastr::error(__('msg_name_already_exists'), __('msg_error'));
            return redirect()->back();
        }
        $donor = new Donor;
        $donor->donor_type = $request->donor_type;
        $donor->donor_name = $request->donor_name;
        $donor->contact_name = $request->contact_name;
        $donor->email = $request->email;
        $donor->phone = $request->phone;
        $donor->address = $request->address;
        $donor->note = $request->note;
        $donor->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function show(Donor $donor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function edit(Donor $donor)
    {
        //
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['types'] = Donor::TYPES;
            $data['row'] = $donor;
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
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donor $donor)
    {
        //
        try{
            $request->validate([
                'donor_name' => 'required|unique:donors,donor_name,'.$donor->id,
            ]);
            //    return $request->all();
                $donor->donor_type = $request->donor_type;
                $donor->donor_name = $request->donor_name;
                $donor->contact_name = $request->contact_name;
                $donor->email = $request->email;
                $donor->phone = $request->phone;
                $donor->address = $request->address;
                $donor->note = $request->note;
                $donor->save();
                Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                return redirect('admin/donor')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donor $donor)
    {
        //
        try{
            $donor;
            if ($donor) {
                 $donor->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
