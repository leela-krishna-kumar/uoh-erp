<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Requisition;
use Illuminate\Http\Request;
use Toastr;
class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct()
      {
      // Module Data
      $this->title = trans_choice('module_requisition', 1);
      $this->route = 'admin.requisition';
      $this->view = 'admin.requisition';
      $this->path = 'requisition';
      $this->access = 'requisition';


      $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-action|'.$this->access.'-delete', ['only'
      => ['index','show']]);
      $this->middleware('permission:'.$this->access.'-action', ['only' =>
      ['create','store','edit','update','penalty']]);
      $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
      $this->middleware('permission:'.$this->access.'-over', ['only' => ['dateOver']]);
      }
    public function index(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = Requisition::STATUSES;
        $requisitions = Requisition::query();
        if (request()->has('status') && request()->get('status')) {
            $requisitions = $requisitions->where('status',request()->get('status'));
        }
        $data['rows'] = $requisitions->get();
         return view($this->view.'.index', $data);
        // return view('admin.requisition.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $data['title'] = $this->title;
       $data['route'] = $this->route;
       $data['view'] = $this->view;
       $data['path'] = $this->path;
       $data['access'] = $this->access;
       $data['statuses'] = Requisition::STATUSES;
       return view($this->view.'.create', $data);
        // return view('admin.requisition.create',$data);
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
          $requisition = new Requisition;
          $requisition->requested_by = auth()->id();
          $requisition->book_name = $request->book_name;
          $requisition->author_name = $request->author_name;
          $requisition->status = $request->status;
          $requisition->remark = $request->remark;
          $requisition->save();
          Toastr::success(__('msg_created_successfully'), __('msg_success'));
          return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Requisition $requisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {
        //
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    //
         $requisition = Requisition::find($id);
         $requisition->book_name = $request->book_name;
         $requisition->author_name = $request->author_name;
         $requisition->status = $request->status;
         $requisition->remark = $request->remark;
         $requisition->save();
         Toastr::success(__('msg_updated_successfully'), __('msg_success'));
         return redirect()->back();
    }


    public function filterByStatus(Request $request, $status)
    {
    // Assuming you have a method to get the requisitions based on status
    $filteredRequisitions = Requisition::getByStatus($status);

    return response()->json(['data' => $filteredRequisitions]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
     try{

        $requisition = Requisition::find($id);
        if($requisition){
        $requisition->delete();
        }

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        return redirect()->back();
        }catch(\Exception $e){

        Toastr::error(__('msg_deleted_fail'), __('msg_error'));

        return redirect()->back();
        }
    }
}
