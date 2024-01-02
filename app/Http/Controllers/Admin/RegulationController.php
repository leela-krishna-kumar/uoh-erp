<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Regulation;
use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Http\Request;
use Toastr;

class RegulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = 'Regulation';
        $this->route = 'admin.regulation';
        $this->view = 'admin.regulation';
        $this->path = 'regulation';
        $this->access = 'regulation';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
         //  try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $regulation = Regulation::query();
            $data['rows'] = $regulation->orderBy('id', 'desc')->get();
            return view($this->view.'.index', $data);
        // } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        // }
        
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
        
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $existName = Regulation::where('name', $request->name)->first();
            if($existName){
                Toastr::error(__('exist_name'), __('msg_error'));
                return redirect()->back();
            }
            $text = trim($_POST['name']);
            $textAr = explode("\r\n", $text);
            $names = array_filter($textAr, 'trim');

            foreach ($names as $name) {
                //check record in DB
                $existName = Regulation::where('name', $name)->first();
                if(!$existName){
                    // Insert Data if name does not exist
                    $regulation = new Regulation;
                    $regulation->name = $name;
                    $regulation->save();
                }
            }

            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function show(Regulation $regulation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function edit(Regulation $regulation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        
        // try{
            // Field Validation
            // return $request->all();
            $request->validate([
                'name' => 'required',
            ]);
            $regulation = Regulation::find($id);

            $regulation->name = $request->name;
            $regulation->save();
            
            // Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        // }
        // catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        // }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalSubmissionCategory  $approvalSubmissionCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        
        // try{
            $regulation = Regulation::find($id);
            if($regulation){
                $batch = Batch::where('regulation_id',$regulation->id)->first();
                if($batch){
                        Toastr::error(__('msg_cant_deleted'), __('msg_error'));
                        return redirect()->back();
                    }
                foreach (Subject::where('regulation_ids','!=',null)->get() as $key => $subject) {
                    $regulation_id = $subject->regulation_id;
                    if (in_array($regulation->id,$subject->regulation_ids)) {
                        Toastr::error(__('msg_cant_deleted'), __('msg_error'));
                        return redirect()->back();
                    }
                }
                $regulation->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        // }catch(\Exception $e){

        //     Toastr::error(__('msg_deleted_fail'), __('msg_error'));

        //     return redirect()->back();
        // }
    } 
}
