<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HolidayMaster;
use Illuminate\Http\Request;
use Toastr;
class HolidayMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
public function __construct()
{
// Module Data
$this->title = trans_choice('module_holiday',2);
$this->route = 'admin.holiday';
$this->view = 'admin.holidays';
$this->path = 'holiday';
$this->access = 'holiday';


$this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete',
['only' => ['index','show']]);
$this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
$this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
$this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
}




    public function index()
    {
        //
  //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $holidayMaster =HolidayMaster::query();
        $data['rows'] = HolidayMaster::orderBy('title', 'asc')->get();

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
         $request->validate([
         'title' => 'required|max:191',
         ]);

         // Insert Data
         $holidayMaster = new HolidayMaster;
         $holidayMaster->title = $request->title;
         $holidayMaster->description = $request->description;
         $holidayMaster->date = $request->date;
         $holidayMaster->save();
         Toastr::success(__('msg_created_successfully'), __('msg_success'));

         return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HolidayMaster  $holidayMaster
     * @return \Illuminate\Http\Response
     */
    public function show(HolidayMaster $holidayMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HolidayMaster  $holidayMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(HolidayMaster $holidayMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HolidayMaster  $holidayMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
         $request->validate([
         'title' => 'required|max:191',
         ]);

         // Update Data
            $holidayMaster = HolidayMaster::find($id);
            $holidayMaster->title = $request->title;
            $holidayMaster->description = $request->description;
            $holidayMaster->date = $request->date;
            $holidayMaster->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HolidayMaster  $holidayMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         try{

         $holidayMaster = HolidayMaster::find($id);
         if($holidayMaster){
           $holidayMaster->delete();
         }

         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }catch(\Exception $e){

         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }
    }
}
