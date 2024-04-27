@extends('student.layouts.student-master')
@section('content')

<!-- Start Content-->
@section('content')
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">

            <h3 class="text-2xl font-medium mb-5"> Account Settings </h3>

            <nav class="cd-secondary-nav border-b md:m-0 -mx-4 nav-small">
                <ul>
                    <li class="active"><a href="#" class="lg:px-2">General </a></li>
                    <li><a href="{{route('student.student-account-setting-privacy')}}" class="lg:px-2"> Privacy </a></li>
                </ul>
            </nav>
            <div class="nav-item">
                <!-- Basic information -->
                <div class="grid lg:grid-cols-3 gap-8 md:mt-12">
                    <div>
                        <div uk-sticky="offset:100;bottom:true;media:992">
                            <h3 class="text-lg mb-2 font-semibold"> Basic</h3>
                            <p> Your account settings as a student allow you to personalize and manage your online presence within the educational system. By accessing your account settings, you can update your personal information, tailor your preferences, and ensure a secure and efficient learning experience. Here is a description of the various settings available to you:</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-md lg:shadow-md shadow col-span-2">

                        <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                            <div>
                                <label for="first-name"> First name</label>
                                <input type="text" placeholder="" id="first-name" class="shadow-none with-border" value="{{$row->first_name}}">
                            </div>
                            <div>
                                <label for="last-name"> Last name</label>
                                <input type="text" placeholder="" id="last-name" class="shadow-none with-border" value="{{$row->last_name}}">
                            </div>
                            <div class="col-span-2">
                                <label for="email"> Email <span class="text-red-600">*</span></label>
                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$row->email}}">
                            </div>
                            <div class="col-span-2">
                                <label for="about">About me</label>  
                                <textarea id="about" name="about" rows="3"  class="with-border"></textarea>
                            </div> 
                                
                            <!-- Website logo  -->
                            <label for="system_info" class="font-medium">Photo  </label>
                            <div class="col-span-2 flex py-2 space-x-5">
                                <img src="{{asset($row->photo)}}" alt="" class="h-12 rounded-full w-12">
                                <a href="#" class="border font-medium px-3 py-1.5 rounded-md self-center shadow-sm text-center text-sm">Change</a>
                            </div>

                            <div class="col-span-2">
                                <label for="Location"> Location</label>
                                <input type="text" placeholder="" id="location" class="shadow-none with-border" value="{{$row->present_address}}">
                            </div>
                            {{-- <div>
                                <label for="working"> Working at</label>
                                <input type="text" placeholder="" id="working" class="shadow-none with-border">
                            </div> 
                            <div>
                                <label for="level"> Level </label>
                                <select id="level" name="relationship" class="shadow-none selectpicker with-border ">
                                    <option value="0">Beginner</option>
                                    <option value="1">Intermediate</option>
                                    <option value="2">Advance</option>
                                    <option value="3">Expert</option>
                                </select>
                            </div> --}}
                        </div> 
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        @include('student.layouts.footer.student-footer')
    </div>
    <!-- Main Contents -->
@endsection

@endsection