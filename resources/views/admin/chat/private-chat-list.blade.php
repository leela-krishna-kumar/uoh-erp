<div class="message-content-inner chat-box">
    @if($conversations->count() > 0)
        @foreach ($conversations as $chat)
            @php 
                $user = App\User::where('id', $chat->sender_id)->first();
            @endphp
            @if ($chat->sender_id == auth()->id())
                <div class="message-bubble me">
                    <div class="message-bubble-inner">
                        <div class="message-avatar"><img src="{{ asset('uploads/user/'.$user->photo) }}" alt="" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';"></div>
                        <div class="message-text bg-primary"><p>{{$chat->message}}</p></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @else
                <div class="message-bubble">
                    <div class="message-bubble-inner">
                        <div class="message-avatar"><img src="https://cdn.gtricks.com/2022/11/how-to-put-two-photos-side-by-side-in-google-photos-desktop-and-android-1280x720.jpeg" alt="" ></div>
                        <div class="message-text"><p>  {{$chat->message}}</p></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif
        @endforeach
    @else
        <div class="text-center py-2 chat-list">
            No Conversation Stated Yet!  <i class="far fa-comment"></i>
        </div>
    @endif
    {{-- <div class="message-bubble me">
        <div class="message-bubble-inner">
            <div class="message-avatar"><img src="https://cdn.gtricks.com/2022/11/how-to-put-two-photos-side-by-side-in-google-photos-desktop-and-android-1280x720.jpeg" alt=""></div>
            <div class="message-text bg-primary"><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,sit amet, consectetuer adipiscing elit 🙂</p></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="message-bubble">
        <div class="message-bubble-inner">
            <div class="message-avatar"><img src="https://cdn.gtricks.com/2022/11/how-to-put-two-photos-side-by-side-in-google-photos-desktop-and-android-1280x720.jpeg" alt=""></div>
            <div class="message-text">
            
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div> --}}
</div>
        