<div id="postLikes" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">{{Str::limit(@$post->content,30)}} Likes</h2>
        </div>
        <div class="uk-modal-body">
            @isset($likes)
                @foreach($likes as $like)
                    <div class="d-flex my-2">
                        @if(is_file('uploads/user/'.$like->createdBy->photo))
                        <img src="{{ asset('uploads/user/'.$like->createdBy->photo) }}" class="posted_by_img" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                        @else
                        <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" class="posted_by_img" alt="{{ __('field_photo') }}">
                        @endif
                        <h5 class="card-title mt-4">{{ $like->createdBy->first_name }} {{ $like->createdBy->last_name }} ({{$like->role ? $like->role->name : 'Student' }})</h5>
                        <!-- <p>{{$like->role ? $like->role->name : 'Student'}}</p> -->
                    </div>
                    <hr>
                @endforeach
            @endisset
        </div>
    </div>
</div>