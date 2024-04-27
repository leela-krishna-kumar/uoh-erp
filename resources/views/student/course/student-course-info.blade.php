@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container p-0">

            <div class="bg-blue-600 md:rounded-b-lg md:-mt-8 md:pb-8 md:pt-12 p-8 relative overflow-hidden" style="background: #1877f2;">

                <div class="lg:w-9/12 relative z-10">

                    <div class="uppercase text-gray-200 mb-2 font-semibold text-sm">{{str_limit($e_course->title, 35) ?? ''}}</div>
                    <h1 class="lg:leading-10 lg:text-3xl text-white text-2xl leading-8 font-semibold">{{str_limit($e_course->description, 50) ?? ''}}</p>
                </div>
            </div>
             
            <div class="lg:flex lg:space-x-4 mt-4">
                <div class="lg:w-8/12 space-y-4">
                    
                    <div class="tube-card z-20 mb-4 overflow-hidden uk-sticky" uk-sticky="cls-active:rounded-none ; media: 992 ; offset:70">
                        <nav class="cd-secondary-nav extanded ppercase nav-small">
                            <ul class="space-x-3" uk-scrollspy-nav="closest: li; scroll: true">
                                <li><a href="#Overview" uk-scroll>Overview</a></li>
                                <li><a href="#curriculum" uk-scroll>Curriculum</a></li>
                            </ul>
                        </nav>
                    </div>


                    <!-- course description -->
                    <div class="tube-card p-6" id="Overview">

                        <div class="space-y-7">
                            <div>
                                <h3 class="text-lg font-semibold mb-3"> Description </h3>
                                <p>
                                    {{$e_course->description ?? ''}}
                                </p>
                            </div>
                        </div>

                    </div>
                    <!-- course Curriculum -->
                    <div id="curriculum">
                        <h3 class="mb-4 text-xl font-semibold"> Course Curriculum </h3>
                        <ul uk-accordion="multiple: true" class="tube-card p-4 divide-y space-y-3">
                            @if($e_sections->count() > 0)
                                @foreach ($e_sections as $e_section)
                                    <li>
                                        <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> 
                                             <div class="mb-1 font-medium mt-4"> {{$e_section->title ?? ''}} </div> 
                                             <div class="text-sm">{{$e_section->short_description ?? ''}}</div>
                                        </a>
                                        <div class="uk-accordion-content mt-3 text-base">
                                            <ul class="course-curriculum-list font-medium">
                                                @php
                                                $e_lessons = App\Models\ELesson::where('e_section_id', $e_section->id)->get();
                                                @endphp
                                                @if($e_sections->count() > 0)
                                                    @foreach ($e_lessons as $e_lesson)
                                                        <a href="{{$e_lesson->link ?? ''}}">
                                                            <li class="hover:bg-gray-200 p-2 flex rounded">
                                                                {{-- <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon> --}}
                                                            @if($e_lesson->type == 0)
                                                                <i class="fa-solid fa-video mr-2 mt-2"></i> 
                                                            @elseif($e_lesson->type == 1) 
                                                                <i class="fas fa-icons mr-2 mt-2"></i> 
                                                            @elseif($e_lesson->type == 2)
                                                                <i class="fas fa-file-alt mr-2 mt-2"></i>
                                                            @elseif($e_lesson->type ==3)
                                                                <i class="fas fa-newspaper mr-2 mt-2"></i> 
                                                            @endif
                                                             {{$e_lesson->title ?? ''}} 
                                                             {{-- <span class="text-sm ml-auto"> 4 min </span> --}}
                                                            </li>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span> No Lesson Found!</span>
                                                @endif
                                            </ul>
                                        </div>
                                    </li> 
                                @endforeach
                            @else
                                <li>
                                    <h5 class="text-center">No Section Found!</h5>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                </div>

                <!-- course intro Sidebar -->
                <div class="lg:w-4/12 space-y-4 lg:mt-0 mt-4">
                    
                    <div uk-sticky="top:600;offset:; offset:90 ; media: 1024">
                        <div class="tube-card p-5" uk-sticky="top:600;offset:; offset:90 ; media: @s"> 

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col space-y-2">
                                    <div class="text-3xl font-semibold"> Time</div>
                                    <div> {{$course_duration}} </div>
                                    <ion-icon name="time" class="text-lg" hidden></ion-icon>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <div class="text-3xl font-semibold"> {{$e_course->eCourseUser->count()}}</div>
                                    <div> Students </div>
                                    <ion-icon name="people-circle" class="text-lg" hidden></ion-icon>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{route('student.student-course-watch', $e_course->id)}}" class="flex items-center justify-center h-9 px-6 rounded-md bg-blue-600 text-white"> Start Now </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- footer -->
        <div class="lg:mt-28 mt-10 mb-7 px-12 border-t pt-7">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <p class="capitalize font-medium"> © copyright 2023  </p>
                <div class="lg:flex space-x-4 text-gray-700 capitalize hidden">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
            </div>
        </div>

    </div>
    <!-- video demo model -->
    <div id="trailer-modal" uk-modal>
        <div class="uk-modal-dialog shadow-lg rounded-md">
            <button class="uk-modal-close-default m-2.5" type="button" uk-close></button>
            <div class="uk-modal-header  rounded-t-md">
                <h4 class="text-lg font-semibold mb-2"> Trailer video </h4>
            </div>
          
            <div class="embed-video">
                <iframe src="https://www.youtube.com/embed/nOCXXHGMezU" class="w-full"
                uk-video="automute: true" frameborder="0" allowfullscreen uk-responsive></iframe>
            </div>


            <div class="uk-modal-body">
                <h3 class="text-lg font-semibold mb-2">Build Responsive Websites </h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore
                    eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident,
                    sunt
                    in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
<!-- Main Contents -->
@endsection
<!-- End Content-->

@endsection

