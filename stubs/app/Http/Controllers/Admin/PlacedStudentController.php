<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PlacedStudent;
use App\Models\Placement;
use App\Models\Student;
use Illuminate\Http\Request;
use Toastr;

class PlacedStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_placed-student', 1);
         $this->route = 'admin.placed-student';
         $this->view = 'admin.placed-student';
         $this->path = 'placed-student';
         $this->access = 'placed-student';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);

     }
 
    public function index()
    {
       try{  
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $placedStudent = PlacedStudent::query();
        $data['placement'] = Placement::where('id',request()->get('placement_id'))->select('company_id')->first();
        $data['rows'] = $placedStudent->where('placement_id',request()->get('placement_id'))->orderBy('id', 'desc')->get();
        
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
    public function create(Request $request)
    {
        try{

            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['students'] = Student::get();
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
        try{
            // return $request->all();
          // Insert Data
          $placedStudent = new PlacedStudent;
          $placedStudent->placement_id = $request->placement_id;
          $placedStudent->student_id = $request->student_id;
          $placedStudent->note = $request->note;
          $placedStudent->package = $request->package;
          $placedStudent->save();
          Toastr::success(__('msg_created_successfully'), __('msg_success'));
          return redirect()->route($this->route.'.index',['placement_id' => $request->placement_id]);
      } catch(\Exception $e){

          Toastr::error(__('msg_updated_error'), __('msg_error'));

          return redirect()->back();
      } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function show(PlacedStudent $placedStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(PlacedStudent $placedStudent)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['students'] = Student::get();
            $data['row'] = $placedStudent;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlacedStudent $placedStudent)
    {
        try{
            // Field Validation
            //   return $request->all();
            $placedStudent->student_id = $request->student_id;
            $placedStudent->placement_id = $placedStudent->placement_id;
            $placedStudent->note = $request->note;
            $placedStudent->package = $request->package;
            $placedStudent->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route.'.index',['placement_id' => $placedStudent->placement_id]);
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlacedStudent $placedStudent)
    {
        try{
            if($placedStudent){
                $placedStudent->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
