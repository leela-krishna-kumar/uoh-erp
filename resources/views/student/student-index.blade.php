@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
            <div class="mt-0">
                <!-- title -->
                <div class="mb-2">
                    <div class="text-2xl font-semibold mb-3 text-black">Web Development Courses</div>
                    <div class="text-sm mt-2">Choose from +10.000 courses with new additions published every months</div>
                </div>

                <!-- nav -->
                <div class="cd-secondary-nav border-b md:m-0 -mx-4" style="">
                    <ul>
                        @foreach($semesters as $key => $semester)
                            <li @if(request()->has('semester') && request()->get('semester') == $semester->id) class="active" @elseif(!request()->has('semester') && $loop->first) class="active" @endif><a href="{{route('student.student-dashboard.index',['semester' => $semester->id])}}" class="lg:px-2"> {{$semester->title}} </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div>
                <!-- course list -->
                @if($e_courses->count() > 0)
                <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-5 mt-5">
                    @foreach ($e_courses as $e_course)
                        <a href="{{route('student.student-courses-info', $e_course->id)}}" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('uploads/ecourse/'.$e_course->image)}}" alt="" class="">
                                    {{-- <img src="{{$e_course->image}}" alt="" class=""> --}}
                                    {{-- <span class="icon-play"></span> --}}
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2"> {{$e_course->title}}
                                    </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        @php 
                                            $interval = Carbon\CarbonInterval::minutes($e_course->duration);
                                            $formatted_duration = $interval->cascade()->forHumans(['short' => true]);
                                            $e_section_id = App\Models\ESection::where('e_course_id', $e_course->id)->pluck('id')->toArray();
                                            $e_lessons = App\Models\ELesson::whereIn('type_id', $e_section_id)->get();
                                        @endphp
                                        <div> {{$formatted_duration}} </div>
                                        <div>·</div>
                                        @if($e_lessons->count() > 0)
                                        <div> {{$e_lessons->count()}} Lec </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @else
                <div class="flex justify-center space-x-2 text-base font-semibold text-gray-400 items-center">
                    @include('student.layouts.no-data')
                </div>
                @endif
            </div>
        </div>
        @include('student.layouts.footer.student-footer')
    </div>
    <!-- Main Contents -->
    @endsection
    <!-- End Content-->
    
    @endsection
            