<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\ChatParticipant;
use Toastr;
use App\User;
use App\Models\Conversation;
use App\Models\Role;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Batch;
use App\Models\Semester;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_chat', 1);
         $this->route = 'admin.chat';
         $this->view = 'admin.chat';
         $this->path = 'chat';
         $this->access = 'chat';
 
 
        //  $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        //  $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        //  $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);

     }
 
    public function index(Request $request)
    {

       try{  
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
      
        $initiatorThread = ChatParticipant::where('user_id',auth()->id())->distinct('chat_room_id')->get()->pluck('chat_room_id');
        $data['chatUsers'] = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->where('role','!=',0)->where('user_id','!=',auth()->id())->distinct('chat_room_id')->get();

        $data['chatStudents'] = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->where('role',0)->where('user_id','!=',auth()->id())->distinct('chat_room_id')->get();

        $participantsUser = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->distinct('chat_room_id')->get();
        $participantsUser = $data['chatUsers']->where('user_id','!=',auth()->id());
        $participantsIds = $participantsUser->pluck('user_id');
        $data['participants'] = User::where('id','!=',auth()->id())->whereNotIn('id',$participantsIds)->whereHas('roles')->latest()->get();
        foreach ($data['participants'] as $participant){
            // $participant->role = $participant->roles[0]->name;
        }
        $data['roles'] = Role::select('id','name')->get();
        if(!empty($request->faculty) || $request->faculty != null){
            $data['selected_faculty'] = $faculty = $request->faculty;
        }
        else{
            $data['selected_faculty'] = $faculty = '0';
        }

        if(!empty($request->program) || $request->program != null){
            $data['selected_program'] = $program = $request->program;
        }
        else{
            $data['selected_program'] = $program = '0';
        }

        if(!empty($request->session) || $request->session != null){
            $data['selected_session'] = $session = $request->session;
        }
        else{
            $data['selected_session'] = $session = '0';
        }

        if(!empty($request->semester) || $request->semester != null){
            $data['selected_semester'] = $semester = $request->semester;
        }
        else{
            $data['selected_semester'] = $semester = '0';
        }

        if(!empty($request->section) || $request->section != null){
            $data['selected_section'] = $section = $request->section;
        }
        else{
            $data['selected_section'] = $section = '0';
        }

        if(!empty($request->status) || $request->status != null){
            $data['selected_status'] = $status = $request->status;
        }
        else{
            $data['selected_status'] = '0';
        }


        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();


        if(!empty($request->faculty) && $request->faculty != '0'){
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();}

        if(!empty($request->program) && $request->program != '0'){
        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();}

        if(!empty($request->program) && $request->program != '0'){
        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();}

        if(!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0'){
        $sections = Section::where('status', 1);
        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
        });
        $data['sections'] = $sections->orderBy('title', 'asc')->get();}
       
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
