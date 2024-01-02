<!-- <div>
    @isset($comments)
        @foreach($comments as $comment)
        <div class="d-flex">
            @if(is_file('uploads/user/'.$comment->createdBy->photo))
            <img src="{{ asset('uploads/user/'.$comment->createdBy->photo) }}" class="posted_by_img" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
            @else
            <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" class="posted_by_img" alt="{{ __('field_photo') }}">
            @endif
            <div>
                <h5 class="card-title mt-1">{{ $comment->createdBy->first_name }} {{ $comment->createdBy->last_name }} ({{$comment->role ? $comment->role->name : 'Student' }})</h5>
                <small>{{$comment->comment}}</small>
            </div>
        </div>
        @endforeach
    @endisset
</div> -->

<ul class="divide-y divide-gray-100 sm:m-0 -mx-5">
    <li>
        <div class="flex items-start space-x-5 p-1">
            @if(is_file('uploads/user/'.auth()->user()->photo))
            <img src="{{ asset('uploads/user/'.auth()->user()->photo) }}" alt="" class="w-10 h-10 rounded-full">
            @else
            <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" alt="" class="w-10 h-10 rounded-full">
            @endif
            <div class="d-flex flex-1 text-left">
                <input type="hidden" name="" value="{{@$count}}" id="new_comment_count_{{@$post->id}}">
                <input type="text" name="comment" id="comment_{{@$post->id}}" class="comment" style="border: 1px solid !important; border-radius: 8px !important;height: 38px;">
                <a href="javascript:void(0)" onclick="storePostComments({{@$post->id}})" class="header_widgets ml-1 mt-2"><i class="fa fa-paper-plane"></i></a>
            </div>
        </div>
    </li>
    @isset($comments)
        @foreach($comments as $comment)
        <li>
            <div class="flex items-start space-x-5 p-1">
                @if(is_file('uploads/user/'.$comment->createdBy->photo))
                <img src="{{ asset('uploads/user/'.$comment->createdBy->photo) }}" alt="" class="w-10 h-10 rounded-full">
                @else
                <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" alt="" class="w-10 h-10 rounded-full">
                @endif
                <div class="flex-1 text-left">
                    <a href="#" class="text-lg font-semibold line-clamp-1">{{ $comment->createdBy->first_name }} {{ $comment->createdBy->last_name }} ({{$comment->role ? $comment->role->name : 'Student' }})</a> 
                    <div class="d-flex justify-content-between">
                        <small> {{ $comment->created_at->diffForHumans() }}</small>
                        <div>
                            <a href="javascript:void(0)" onclick="getPostCommentLikes({{$comment->id}},{{$post->id}})" class="header_widgets">
                            <small id="comment_like_count_{{$comment->id}}_{{$post->id}}">
                                @if($comment->likes->count() > 0)
                                    {{$comment->likes->count()}}
                                @endif
                            </small>
                            <a href="javascript:void(0)" onclick="storePostCommentLikes({{$comment->id}},{{$post->id}})" class="header_widgets">
                                <span id="store_comment_likes_{{$comment->id}}_{{$post->id}}" >
                                @if($comment->likes->where('user_id',auth()->id())->first()) 
                                    <i class="fa fa-thumbs-up" style="color: #007bff"></i>
                                @else
                                    <i class="fa fa-thumbs-up"></i>
                                @endif
                                </span> 
                            </a>
                        </div>
                    </div>
                    <p class="leading-6 line-clamp-2">{{$comment->comment}}</p>
                </div>
                <!-- <div class="sm:flex items-center space-x-4 hidden">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 5a2 2 0 010-2h7a2 2 0 010 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>
                    <span class="text-xl"> 4 </span>
                </div> -->
            </div>
        </li>
        @endforeach
    @endisset
</ul>