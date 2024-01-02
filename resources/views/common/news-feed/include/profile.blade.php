{{-- <div class="card text-center p-5">
    <div class="card-header">
        <h5>Profile</h5>
    </div>
    <div class="card-block">
        <div class="card-body">
            @if(is_file('uploads/'.$path.'/'.$row->photo))
            <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" class="w-70 h-70 rounded-full" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';" style="margin-left: 0%;">
            @else
            <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" class="w-70 h-70 rounded-full" alt="{{ __('field_photo') }}"style="margin-left: 0%;">
            @endif
            <h5 class="card-title mt-5">{{ $row->first_name }} {{ $row->last_name }}</h5>
        </div>
    </div>
</div> --}}

<div class="card profile-card" style="position: sticky;top:15px;">
    <div class="card_background_img"></div>
    @if(is_file('uploads/'.$path.'/'.$row->photo))
    <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" class="card_profile_img">
    @else
    <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" class="card_profile_img">
    @endif
    <!-- <img src="https://source.unsplash.com/7Sz71zuuW4k" class="card_profile_img"> -->
    <div class="user_details text-center">
        <h3>{{ $row->first_name }} {{ $row->last_name }}</h3>
        <p>BTech CE 2023-2027 Sec-A</p>
    </div>
    
    <div class="card_count card-prime">
        <a href="" class="writing-assistant">
            <p class="mb-2 text-center">
                Share meaningful information with collage community members & get traction.
            </p>
        </a>  
    </div>
</div>