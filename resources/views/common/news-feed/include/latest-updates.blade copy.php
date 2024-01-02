<div class="card text-center p-5">
    <div class="card-header">
        <h5>Updates</h5>
    </div>
    <div class="card-block">
        <div class="card-body ajax-container">
            @if($latestUpdates->count() > 0)
                @foreach($latestUpdates as $updates)
                <ul class="divide-y divide-gray-100 sm:m-0">
                    <li>
                        <div class="flex items-start space-x-5 p-1">
                            @if(is_file('uploads/user/'.$updates->createdBy->photo))
                            <img src="{{ asset('uploads/user/'.$updates->createdBy->photo) }}" alt="" class="w-8 h-8 rounded-full">
                            @else
                            <img src="{{ asset('dashboard/images/user/avatar-1.jpg') }}" alt="" class="w-8 h-8 rounded-full">
                            @endif
                            <div class="d-flex flex-1 text-left">
                                <p class="card-title">{{ $row->first_name }} {{ $row->last_name }} React on your post - {{Str::limit($updates->post->content,30)}}</p>
                            </div>
                        </div>
                    </li>
                </ul>
                @endforeach
            @else
                <p>No updates</p>
            @endif
        </div>
    </div>
</div>