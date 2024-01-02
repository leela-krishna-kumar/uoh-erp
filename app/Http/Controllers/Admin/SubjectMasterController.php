<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SubjectMaster;
use Illuminate\Http\Request;
use Toastr;

class SubjectMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
     // Module Data
     $this->title = trans_choice('module_subject_master', 1);
     $this->route = 'admin.subject-master';
     $this->view = 'admin.subject_master';
     $this->path = 'subjectmaster';
     $this->access = 'subject_master';


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
        $subjectMaster =SubjectMaster::query();
        $data['rows'] = SubjectMaster::orderBy('subject', 'asc')->get();
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
        $existRecord = SubjectMaster::where('subject',$request->subject)->first();
        if($existRecord){
            Toastr::error(__('msg_name_already_exists'), __('msg_error'));
            return redirect()->back();
        }
        $subjectMaster = new SubjectMaster;
        $subjectMaster->subject = $request->subject;       
        $subjectMaster->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

         return redirect()->back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubjectMaster  $subjectMaster
     * @return \Illuminate\Http\Response
     */
    public function show(SubjectMaster $subjectMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubjectMaster  $subjectMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(SubjectMaster $subjectMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubjectMaster  $subjectMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'subject' => 'required|unique:subject_masters,subject,'.$chapter->id,
        ]);
           $subjectMaster = SubjectMaster::find($id);
           $subjectMaster->subject = $request->subject;
           $subjectMaster->save();
           Toastr::success(__('msg_updated_successfully'), __('msg_success'));

           return redirect()->back();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubjectMaster  $subjectMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

         try{

         $subjectMaster = SubjectMaster::find($id);
         if($subjectMaster){
         $subjectMaster->delete();
         }

         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }catch(\Exception $e){

         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }
    }
}
