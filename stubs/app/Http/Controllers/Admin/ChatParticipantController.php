<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ChatParticipant;
use Illuminate\Http\Request;
use Toastr;

class ChatParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
             // Module Data
             $this->title = trans_choice('module_chat_participant', 1);
             $this->route = 'admin.chat-participant';
             $this->view = 'admin.chat-participant';
             $this->path = 'chat-participant';
             $this->access = 'chat-participant';
     
     
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
            $chatParticipant = ChatParticipant::query();      
            $data['rows'] = $chatParticipant->orderBy('id', 'desc')->get();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function show(ChatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatParticipant $chatParticipant)
    {
        //
    }
}
