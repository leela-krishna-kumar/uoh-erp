 
    <div class="uk-sticky card p-3" style="position: sticky; top:15px;">
        <span class="icon-material-outline-star-border" style="font-size: 45px;margin-bottom: 10px;color: #2196f3">
                                     
        </span>
        <h2 class="text-xl font-semibold mb-0"> Top Contributors </h2>
        {{-- <br> --}}
        {{-- <ul class="space-y-3">
            <li>
                <div class="flex items-center space-x-3">
                    <img src="../assets/images/avatars/avatar-1.jpg" alt="" class="w-8 h-8 rounded-full">
                    <a href="#" class="font-semibold"> Stella Johnson </a>
                    <div class="flex items-center space-x-2">
                        <ion-icon name="chatbubble-ellipses-outline" class="text-lg md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>
                        <span> 137 </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-3">
                    <img src="../assets/images/avatars/avatar-2.jpg" alt="" class="w-8 h-8 rounded-full">
                    <a href="#" class="font-semibold"> Adrian Mohani </a>
                    <div class="flex items-center space-x-2">
                        <ion-icon name="chatbubble-ellipses-outline" class="text-lg md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>
                        <span> 14 </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-3">
                    <img src="../assets/images/avatars/avatar-3.jpg" alt="" class="w-8 h-8 rounded-full">
                    <a href="#" class="font-semibold"> Alex Dolgove </a>
                    <div class="flex items-center space-x-2">
                        <ion-icon name="chatbubble-ellipses-outline" class="text-lg md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>
                        <span> 257 </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-3">
                    <img src="../assets/images/avatars/avatar-1.jpg" alt="" class="w-8 h-8 rounded-full">
                    <a href="#" class="font-semibold"> Stella Johnson </a>
                    <div class="flex items-center space-x-2">
                        <ion-icon name="chatbubble-ellipses-outline" class="text-lg md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>
                        <span> 137 </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-3">
                    <img src="../assets/images/avatars/avatar-2.jpg" alt="" class="w-8 h-8 rounded-full">
                    <a href="#" class="font-semibold"> Adrian Mohani </a>
                    <div class="flex items-center space-x-2">
                        <ion-icon name="chatbubble-ellipses-outline" class="text-lg md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>
                        <span> 14 </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-3">
                    <img src="../assets/images/avatars/avatar-3.jpg" alt="" class="w-8 h-8 rounded-full">
                    <a href="#" class="font-semibold"> Alex Dolgove </a>
                    <div class="flex items-center space-x-2">
                        <ion-icon name="chatbubble-ellipses-outline" class="text-lg md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>
                        <span> 257 </span>
                    </div>
                </div>
            </li>
        </ul> --}}
        @if($latestUpdates->count() > 0)
            @foreach($latestUpdates as $updates)
                <ul class="divide-y divide-gray-100 sm:m-0">
                    <li>
                        <div class="flex items-start space-x-5 p-1">
                            @if(is_file('uploads/user/'.@$updates->createdBy->photo))
                            <img src="{{ asset('uploads/user/'.@$updates->createdBy->photo) }}" alt="" class="w-8 h-8 rounded-full">
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
            <p> Coming Soon! </p>
        @endif
    </div>