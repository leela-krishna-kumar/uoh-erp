{{-- <div class="card text-center mt-2 p-1">
    <ul class="divide-y divide-gray-100 sm:m-0 -mx-5">
        <li>
            <div class="flex items-start space-x-5 p-1">
                @if(is_file('uploads/user/'.auth()->user()->photo))
                <img src="{{ asset('uploads/user/'.auth()->user()->photo) }}" alt="" class="w-10 h-10 rounded-full">
                @else
                <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" alt="" class="w-10 h-10 rounded-full">
                @endif
                <div class="d-flex flex-1 text-left">
                    <input type="text" href="javascript:void(0)" uk-toggle="target: #addPost" placeholder="Start a post" name="post" class="post" style="border: 1px solid !important; border-radius: 8px !important;height: 38px;">
                </div>
            </div>
        </li>
    </ul>
</div> --}}
<div class="card text-center p-1">
    <ul class="divide-y divide-gray-100 sm:m-0 -mx-5">
        <li>
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="pl-5">
                        @if(is_file('uploads/user/'.auth()->user()->photo))
                        <img src="{{ asset('uploads/user/'.auth()->user()->photo) }}" alt="" class="profile-img">
                        @else
                        <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" alt="" class="profile-img">
                        @endif
                    </div>
                </div>
                <div class="col-lg-10 pl-0 pr-lg-5 pr-5 pl-25">
                    <button href="javascript:void(0)" uk-toggle="target: #addPost" name="post" class="post left-aligned-btn text-dark post-modal-button">Start a post...</button>
                </div>
                
            </div>
        </li>
    </ul>
</div>
<div class="ajax-container">
    @if($posts->count() > 0)
        @foreach($posts as $post)
            <div class="card text-center mt-lg-0 mt-4 p-1">
                <div class="card-header p-2">
                   <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            @if(is_file('uploads/'.$path.'/'.$row->photo))
                            <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" class="w-10 h-10 rounded-full" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                            @else
                            <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" class="w-10 h-10 rounded-full" alt="{{ __('field_photo') }}">
                            @endif
                            <div class="text-left"> 
                                <h5 class="mt-1 font-bold">{{$post->createdBy->name}}</h5>
                                <div style="line-height: 10px !important; margin-left: -0px;font-size: 14px">
                                    <span class="mr-1">{{$post->role ? $post->role->name : 'Student' }} </span>
                                    <span><i class="fa fa-clock fa-sm"></i> {{$post->created_at->diffForHumans()}}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="open-list">
                                <span class="icon-feather-more-vertical font-semibold" style="font-size: 18px;float: inline-end;"></span>
                            </a>
                            <div class="dropdown-content">
                                <a href="#">Delete</a>
                                <a href="#">Report</a>
                            </div>
                        </div>
                        
                   </div>
                </div>
                <div class="card-body text-left">
                    <p>{{$post->content}}</p>
                    @if($post->media)
                        <img src="{{ asset('uploads/post/'.$post->media) }}" class="w-100 h-100 mt-2" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';" style="width: 100%; height: auto;">
                    @endif
                </div>
                <div class="d-flex justify-content-between p-2">
                    @if($post->likes->count() > 0)
                        <a href="javascript:void(0)" onclick="getPostLikes({{$post->id}})" class="header_widgets font-semibold mr-4">
                        <span id="like_count_{{$post->id}}"> {{$post->likes->count()}} </span>
                        Likes
                        </a>
                    @else
                        <span id="like_count_{{$post->id}}"> No Like Yet!</span>
                    @endif
                    @if($post->comments->count() > 0)
                        <a href="javascript:void(0)" onclick="getPostComments({{$post->id}})" class="header_widgets font-semibold">
                        <span id="comment_count_{{$post->id}}"> {{$post->comments->count()}} </span>
                        Comments             
                        </a>
                    @else
                        <span id="comment_count_{{$post->id}}"> No Comment Yet!</span>  
                    @endif
                </div>
                <hr>
                <div class="card-footer p-2">
                    <div class="d-flex">
                        <a href="javascript:void(0)" onclick="storePostLikes({{$post->id}})" class="header_widgets mr-4">
                        <span id="store_post_likes_{{$post->id}}" >
                            @if($post->likes->where('user_id',auth()->id())->first()) 
                            <div  style="color: #007bff">
                                <i class="fa fa-thumbs-up"></i> <span class="font-bold"> Liked </span>
                            </div>
                            @else
                                <i class="fa fa-thumbs-up"></i> <span class="font-bold">
                                    Like
                                </span>
                            @endif
                            </span> 
                        </a>
                        <a href="javascript:void(0)" onclick="getPostComments({{$post->id}})" class="header_widgets">
                            <span><i class="fa fa-comment"></i></span>  <span class="font-bold"> Comment </span>
                        </a>
                    </div>
                </div>
                <div id="comment_container_{{$post->id}}" class="p-2" style="display:none;">
                    <hr>
                </div>
                
            </div>
        @endforeach
    @else
    <div>
        No Post Avilable to View!
    </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const openList = document.querySelector('.open-list');
    const dropdownContent = document.querySelector('.dropdown-content');

    openList.addEventListener('click', function(e) {
        e.preventDefault();
        dropdownContent.classList.toggle('show');
    });
});
</script>