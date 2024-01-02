<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Toastr;
use App\Models\ChatParticipant;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
            // Module Data
            $this->title = trans_choice('module_conversation', 1);
            $this->route = 'student.conversation';
            $this->view = 'student.conversation';
            $this->path = 'conversation';
            $this->access = 'conversation';
    }
    public function store(Request $request)
    {
        // return $request->all();
        $conversationThread = ChatParticipant::where('chat_room_id',$request->chat_room_id)->first();
        if(!$conversationThread){
            $conversationThread = new ChatParticipant();
            $conversationThread->user_id = auth()->id();
            $conversationThread->save();
        }
        $conversationUser = ChatParticipant::find($request->user_id);

        $conversation = new Conversation();
        $conversation->sender_id = $request->user_id;
        $conversation->chat_room_id = $conversationThread->chat_room_id;
        $conversation->message = $request->message;
        $conversation->save();

        if ($request->has('image')) {
            $folderPath = storage_path('app/public/uploads/conversations');
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.png';
            $imagePath = $folderPath.$imageName;
            $name = Str::random(64);
            $ext = 'png';
            $fileName = $imageName;
            $filePath = "storage/uploads/conversations/" . $imageName;
            file_put_contents($filePath, $image_base64);
            Media::create([
                'type' => "Conversations",
                'type_id' => $conversation->id,
                'file_name' => $imageName,
                'path' => $filePath,
                'extension' => $ext,
                'file_type' => ''
            ]);
        }

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = Str::random(64);
                $ext = strtolower($file->getClientOriginalExtension());
                $target = storage_path('app/public/uploads/conversations');
                $fileName = $name . "." . $ext;
                $filePath = "storage/uploads/conversations/" . $fileName;

                $file->move($target, $fileName);

                Media::create([
                    'type' => "Conversations",
                    'type_id' => $conversation->id,
                    'file_name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'extension' => $ext,
                    'file_type' => ''
                ]);
            }
        }

        $conversations = Conversation::where('chat_room_id',$conversation->chat_room_id)->get();
        $firstConversation = $conversations->first();
        $conversations_thread_id = $firstConversation ? $firstConversation->chat_room_id : null;
        $user_id = $request->user_id;
        $view = view('student.chat.private-chat-list', compact('conversations','user_id','conversations_thread_id'));
        return $view;
    
    }


    public function getUserConversation(Request $request){
        $chatParticipant = ChatParticipant::where('user_id',$request->user_id)->first();
        $conversations = Conversation::where('chat_room_id',$request->chat_room_id)->get();
        $user_id = $request->user_id;
        $view = view('student.chat.private-chat-list', compact('conversations','user_id'));
        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
