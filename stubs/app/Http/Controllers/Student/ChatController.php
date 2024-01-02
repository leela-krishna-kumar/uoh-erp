<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\ChatParticipant;
use Toastr;
use App\User;
use App\Models\Conversation;
use App\Models\Role;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     public function __construct()
     {
         $this->title = trans_choice('module_chat', 1);
         $this->route = 'student.chat';
         $this->view = 'student.chat';
     }
 
    public function index()
    {
       try{  
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
      
        $initiatorThread = ChatParticipant::where('user_id',auth()->id())->distinct('chat_room_id')->get()->pluck('chat_room_id');
        $data['chatUsers'] = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->where('user_id','!=',auth()->id())->distinct('chat_room_id')->get();

        $participantsUser = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->distinct('chat_room_id')->get();
        $participantsUser = $data['chatUsers']->where('user_id','!=',auth()->id());
        $participantsIds = $participantsUser->pluck('user_id');
        $data['participants'] = User::where('id','!=',auth()->id())->whereNotIn('id',$participantsIds)->latest()->get();
        $data['roles'] = Role::select('id','name')->get();

        return view($this->view.'.index', $data);
    } catch(\Exception $e){
        Toastr::error(__('msg_error'), __('msg_error'));
        return redirect()->back();
    } 
    //

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
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat , Request $request)
    {
        // return $request->all();
      
    }

    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApprovalSubmission  $approvalSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovalSubmission $approvalSubmission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalSubmission  $approvalSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalSubmission $approvalSubmission)
    {
  
        
    }

   
   
    
}
