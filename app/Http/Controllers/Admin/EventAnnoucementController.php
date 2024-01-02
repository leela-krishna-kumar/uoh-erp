<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Toastr;
use App\Models\EventAnnoucement;
use App\Models\Event;

class EventAnnoucementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


      public function __construct()
      {
      // Module Data
      $this->title = trans_choice('module_event_announcement', 1);
      $this->route = 'admin.event-announcement';
      $this->previous_route = 'admin.event';
      $this->view = 'admin.event_announcement';
      $this->path = 'event_announcement';
      $this->access = 'event_announcement';
      $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card',
      ['only' => ['index','show','status','sendPassword']]);
      $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
      $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
      $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
      }
    public function index(Request $request)
    {
        //
        $data['event_id'] =$request->event_id;
        $data['event'] =Event::find($request->event_id);
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $events = EventAnnoucement::query();
        $data['rows'] = $events->orderBy('id', 'desc')->get();
        $data['roles'] = User::select('id','first_name')->get();
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
        $data['event_id'] =$request->event_id;
        $event = new EventAnnoucement;
        $event->event_id = $request->event_id;
        $event->user_id = auth()->id();
        $event->date = $request->date;
        $event->remark = $request->remark;
        $event->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\EventAnnoucement  $eventAnnoucement
     * @return \Illuminate\Http\Response
     */
    public function show(EventAnnoucement $eventAnnoucement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\EventAnnoucement  $eventAnnoucement
     * @return \Illuminate\Http\Response
     */
    public function edit(EventAnnoucement $eventAnnoucement)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\EventAnnoucement  $eventAnnoucement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $eventAnnoucement = EventAnnoucement::find($id);
        $data['event_id'] =$request->event_id;
        $eventAnnoucement->date = $request->date;
        $eventAnnoucement->remark = $request->remark;
        $eventAnnoucement->save();    
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\EventAnnoucement  $eventAnnoucement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try{
       $eventAnnoucement = EventAnnoucement::find($id);
       if($eventAnnoucement){
       $eventAnnoucement->delete();
       }
       Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
       return redirect()->back();
       }catch(\Exception $e){
       Toastr::error(__('msg_deleted_fail'), __('msg_error'));

       return redirect()->back();
       }
    }
}
