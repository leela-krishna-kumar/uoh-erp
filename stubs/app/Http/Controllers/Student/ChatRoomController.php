<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Toastr;
use App\Models\ChatParticipant;
use App\User;


class ChatRoomController extends Controller
{

    public function storeChatRoomUser(Request $request)
    {

        // dd($request->all());
        $initiatorThread = ChatParticipant::where('user_id',auth()->id())->distinct('conversation_thread_id')->get()->pluck('chat_room_id');
        $chatUsers = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->distinct('chat_room_id')->get();
        $chatUsers = $chatUsers->where('user_id',$request->receiver_id)->first();
        $chat_room_id = $chatUsers ? $chatUsers->chat_room_id : null;
        $chatRoom = ChatRoom::find($chat_room_id);
        if(!$chatRoom){
            $chatRoom = new ChatRoom();
            $chatRoom->user_id = auth()->id();
            $chatRoom->title = 'Private Chat Room';
            $chatRoom->save();
        }

        $chatParticipant = ChatParticipant::where('user_id',(auth()->id()))->where('chat_room_id',$chatRoom->id)->first();
        if(!$chatParticipant){
            $chatParticipant = new ChatParticipant();
            $chatParticipant->user_id = auth()->id();
            $chatParticipant->chat_room_id = $chatRoom->id;
            $chatParticipant->role = 0;
            $chatParticipant->save();
        }
        $chatReceiver = ChatParticipant::where('user_id',$request->receiver_id)->where('chat_room_id',$chatRoom->id)->first();
        if(!$chatReceiver){
            $chatReceiver = new ChatParticipant();
            $chatReceiver->user_id = $request->receiver_id;
            $chatReceiver->chat_room_id = $chatRoom->id;
            $chatReceiver->role = $request->role_id;
            $chatReceiver->save();
        }
        
        $initiatorThread = ChatParticipant::where('user_id',auth()->id())->distinct('chat_room_id')->get()->pluck('chat_room_id');
        $chatUsers = ChatParticipant::where('user_id','!=',(auth()->id()))->whereIn('chat_room_id',$initiatorThread)->distinct('chat_room_id')->latest()->get();
        $view = view('student.chat.chat_area', compact('chatUsers'));
        $userData = User::where('id', $chatReceiver->user_id)->first();
        return $view;
    }

    public function getRoleUser(Request $request)
    {
        $user = User::where('id','!=',auth()->id())->where('status', '1');
        $user->with('roles')->whereHas('roles', function ($query) use( $request){
            $query->where('id', $request->role_id);
        });
        $initiatorThread = ChatParticipant::where('user_id',auth()->id())->distinct('chat_room_id')->get()->pluck('chat_room_id');
        $data['chatUsers'] = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->where('user_id','!=',auth()->id())->where('role','!=',0)->distinct('chat_room_id')->get();

        $participantsUser = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->distinct('chat_room_id')->get();
        $participantsUser = $data['chatUsers']->where('user_id','!=',auth()->id());
        $participantsIds = $participantsUser->pluck('user_id');

        $chatUser = $user->whereNotIn('id',$participantsIds)->latest()->get();
        $html = '<option value="" class="bg-grey" readonly> -- Select User To Start Chat -- </option>';
        foreach ($chatUser as $index => $user) {
            $html .= '<option value="'.$user->id.'" data-name="'.$user->first_name.'">#CEUID'.$user->id.' - '. $user->first_name.'</option>';
        }
        return $html;
    }

    public function getRoleStudent(Request $request)
    {
        $enrolls = StudentEnroll::where('status', '1');
        if(isset($request->faculty) || isset($request->program)){
            if(!empty($request->faculty) && $request->faculty != '0'){
                $enrolls->with('program')->whereHas('program', function ($query) use ($request){
                    $query->where('faculty_id', $request->faculty);
                });
            }
            if(!empty($request->program) && $request->program != '0'){
                $enrolls->where('program_id', $request->program);
            }
            if(!empty($request->session) && $request->session != '0'){
                $enrolls->where('session_id', $request->session);
            }
            if(!empty($request->semester) && $request->semester != '0'){
                $enrolls->where('semester_id', $request->semester);
            }
            if(!empty($request->section) && $request->section != '0'){
                $enrolls->where('section_id', $request->section);
            }

            $enrolls->with('student')->whereHas('student', function ($query){
                $query->where('status', '1');
                $query->orderBy('student_id', 'asc');
            });
        }
        $students = $enrolls->get();

        $initiatorThread = ChatParticipant::where('user_id',auth()->id())->distinct('chat_room_id')->get()->pluck('chat_room_id');
        $data['chatUsers'] = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->where('role',0)->where('user_id','!=',auth()->id())->distinct('chat_room_id')->get();

        $data['chatStudents'] = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->where('role',0)->where('user_id','!=',auth()->id())->distinct('chat_room_id')->get();


        $participantsUser = ChatParticipant::whereIn('chat_room_id',$initiatorThread)->distinct('chat_room_id')->get();
        $participantsUser = $data['chatUsers']->where('user_id','!=',auth()->id());
        $participantsIds = $participantsUser->pluck('user_id');

        $chatUser = $students->whereNotIn('student_id',$participantsIds);
        $html = '<option value="" class="bg-grey" readonly> -- Select Student To Start Chat -- </option>';
        foreach ($chatUser as $index => $user) {
            $html .= '<option value="'.$user->student->id.'" data-name="'.$user->student->first_name.'">#CEUID'.$user->student->id.' - '. $user->student->first_name.'</option>';
        }
        return $html;
    }
}
