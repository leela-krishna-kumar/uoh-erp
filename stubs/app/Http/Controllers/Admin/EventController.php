<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventCategory;
use Carbon\Carbon;
use Toastr;
use App\Models\EventUser;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_event', 1);
        $this->route = 'admin.event';
        $this->view = 'admin.event';
        $this->path = 'event';
        $this->access = 'event';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-calendar', ['only' => ['calendar']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $events = Event::query();
        $data['event_categories'] = EventCategory::get();
        if(request()->get('start_date') && request()->get('end_date') ){
            $events->whereBetween('start_date', [request()->get('start_date'),request()->get('end_date')]);
        }
        $data['rows'] = $events->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('id','name')->get();


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
        // Field Validation
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Insert Data
        $event = new Event;
        $event->title = $request->title;
        $event->role_id = $request->role_id;
        $event->category_id = $request->category_id;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->color = $request->color;
        $event->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        // Field Validation
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Update Data
        $event->title = $request->title;
        $event->start_date = $request->start_date;
        $event->role_id = $request->role_id;
        $event->category_id = $request->category_id;
        $event->end_date = $request->end_date;
        $event->color = $request->color;
        $event->status = $request->status;
        $event->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        // Delete Data
        $event->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        $role_id = auth()->user()->roles[0]->id;
        $data['title'] = trans_choice('module_calendar', 1);
        $data['route'] = 'calendar';
        $eventIds = EventUser::where('user_id',auth()->id())->pluck('event_id')->toArray();
        
        // $data['rows'] = Event::where('status','1')->where('role_id', $role_id)->orderBy('id', 'asc')->get();
        // $data['latest_events'] = Event::where('status', '1')
        //                         ->where('role_id', $role_id)
        //                         ->where('end_date', '>=', Carbon::today())
        //                         ->orderBy('start_date', 'asc')
        //                         ->get();
        $data['rows'] = Event::where('status','1')->whereIn('id',$eventIds)->where('role_id', $role_id)->orderBy('id', 'asc')->get();
        $data['latest_events'] = Event::where('status', '1')
                                ->where('role_id', $role_id)
                                ->whereIn('id',$eventIds)
                                ->where('end_date', '>=', Carbon::today())
                                ->orderBy('start_date', 'asc')
                                ->get();
      
        return view('admin.calendar.index', $data);
    }
}
