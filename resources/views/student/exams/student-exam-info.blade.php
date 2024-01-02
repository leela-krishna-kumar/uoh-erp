@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
 
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">

            <div class="text-2xl font-semibold">Exam </div>
            <nav class="cd-secondary-nav border-b md:m-0 nav-small">
                <ul>
                    <li class="active"><a href="#exam_to_be_done" class="lg:px-2">Exam To Be Done</a></li>
                    <li><a class="lg:px-2" href="#completed" uk-scroll >Completed</a></li>
                    <li><a class="lg:px-2" href="#started" uk-scroll >Started</a></li>
                </ul>
            </nav>
            @if($testPapersPending->count() > 0)
                @foreach($testPapersPending as $testPaper)
                @php 
                    $interval = Carbon\CarbonInterval::minutes($testPaper->duration);
                    $formatted_duration = $interval->cascade()->forHumans(['short' => true]);
                @endphp
                <div class=" lg:-mx-4 mt-6" id="exam_to_be_done">
                    <div class="">
                        <div class="divide-y tube-card px-6 md:m-0 -mx-5 py-1">         
                            <div class="md:space-x-6 py-2">
                                <div class="md:pt-0 pt-4">
                                    <p class="text-lg font-semibold line-clamp-2 leading-8">{{$testPaper->title}}</p>
                                    <div class="d-flex justify-between">
                                        <div class="flex items-center text-sm">
                                            <span name="" class="side-con icon-feather-book-open text-lg mr-2"></span>
                                            <div class="flex items-center">Total Question {{$testPaper->testPaperQuestions ? $testPaper->testPaperQuestions->count() : '0'}}</div>
                                            <div class="flex items-center mx-4"> 
                                                <span name="" class="side-icon icon-material-outline-access-time text-lg mr-2"></span> {{$formatted_duration}} 
                                            </div>
                                        </div>
                                        <div class="grid md:gap-6 gap-3">
                                            <a class="bg-blue-600 text-white flex font-medium items-center justify-center py-1 px-3 rounded-md hover:text-white" href="{{route('student.student-exam-disclaimer',$testPaper->id)}}">
                                                <span class="md:block hidden">Start Exam </span><span class="md:hidden block">Review</span>
                                                <span class="icon-material-outline-arrow-forward text-lg"></span>
                                            </a>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            @if($testPapersCompleted->count() > 0)
                {{-- <h3 class="mb-4 text-xl font-semibold mt-5"> Completed </h3> --}}
                @foreach($testPapersCompleted as $testPaper)
                @php 
                    $interval = Carbon\CarbonInterval::minutes($testPaper->duration);
                    $formatted_duration = $interval->cascade()->forHumans(['short' => true]);
                @endphp
                <div class=" lg:-mx-4 mt-6" id="completed">
                    <div class="">
                        <div class="divide-y tube-card px-6 md:m-0 -mx-5 py-1">         
                            <div class="md:space-x-6 py-2">
                                <div class="md:pt-0 pt-4">
                                    <p class="text-lg font-semibold line-clamp-2 leading-8">{{$testPaper->title}}</p>
                                    <div class="d-flex justify-between">
                                        <div class="flex items-center text-sm">
                                            <span name="" class="side-con icon-feather-book-open text-lg mr-2"></span>
                                            <div class="flex items-center">Total Question {{$testPaper->testPaperQuestions ? $testPaper->testPaperQuestions->count() : '0'}}</div>
                                            <div class="flex items-center mx-4"> 
                                                <span name="" class="side-icon icon-material-outline-access-time text-lg mr-2"></span> {{$formatted_duration}} 
                                            </div>
                                        </div>
                                        <div class="grid md:gap-6 gap-3">
                                            <a class="bg-blue-600 text-white flex font-medium items-center justify-center py-1 px-3 rounded-md hover:text-white"  href="{{route("student.student-exam-report",$testPaper->id)}}" >
                                                <span class="md:block hidden">Access Report </span><span class="md:hidden block">Review</span>
                                                <span class="icon-material-outline-arrow-forward text-lg"></span>
                                            </a>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            @if($testPapersStarted->count() > 0)
            {{-- <h3 class="mb-4 text-xl font-semibold mt-5"> Started </h3> --}}
            @foreach($testPapersStarted as $testPaper)
                @php 
                    $interval = Carbon\CarbonInterval::minutes($testPaper->duration);
                    $formatted_duration = $interval->cascade()->forHumans(['short' => true]);
                @endphp
                <div class=" lg:-mx-4 mt-6" id="started">
                    <div class="">
                        <div class="divide-y tube-card px-6 md:m-0 -mx-5 py-1">         
                            <div class="md:space-x-6 py-2">
                                <div class="md:pt-0 pt-4">
                                    <p class="text-lg font-semibold line-clamp-2 leading-8">{{$testPaper->title}}</p>
                                    <div class="d-flex justify-between">
                                        <div class="flex items-center text-sm">
                                            <span name="" class="side-con icon-feather-book-open text-lg mr-2"></span>
                                            <div class="flex items-center">Total Question {{$testPaper->testPaperQuestions ? $testPaper->testPaperQuestions->count() : '0'}}</div>
                                            <div class="flex items-center mx-4"> 
                                                <span name="" class="side-icon icon-material-outline-access-time text-lg mr-2"></span> {{$formatted_duration}} 
                                            </div>
                                        </div>
                                        <div class="grid md:gap-6 gap-3">
                                            <form action="{{route('student.student-exam-started',$testPaper->id)}}" method="post">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 text-white flex font-medium items-center justify-center py-1 px-3 rounded-md hover:text-white"  href="{{route("student.student-exam-started",$testPaper->id)}}" >
                                                    <span class="md:block hidden">Resume Test </span><span class="md:hidden block">Review</span>
                                                    <span class="icon-material-outline-arrow-forward text-lg"></span>
                                                </button>
                                            </form>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            {{-- <div class=" lg:-mx-4 mt-6">
                <div class="">
                    <div class="divide-y tube-card px-6 md:m-0 -mx-5 py-1">
                                
                        <div class="md:space-x-6 py-2">
                            <div class="md:pt-0 pt-4"> 
                                <p class="text-lg font-semibold line-clamp-2 leading-8">Java Programming 6 Mid Exam</p>
                                <div class="d-flex justify-between">
                                    <div>
                                        <p class="line-clamp-2">Mid Sem Exam Start</p>  
                                    </div>
                                    <div class="grid md:gap-6 gap-3">
                                        <a class="bg-blue-600 text-white flex font-medium items-center justify-center py-1 px-3 rounded-md hover:text-white" href="">
                                            <span class="md:block hidden">Start Exam </span><span class="md:hidden block">Review</span>
                                            <span class="icon-material-outline-arrow-forward text-lg"></span>
                                        </a>
                                    </div>  
                                </div>
                                <div class="flex items-center text-sm">
                                    <span name="" class="side-con icon-feather-book-open text-lg mr-2"></span>
                                    <div class="flex items-center">Toal Question 20</div>
                                    <div class="flex items-center mx-4"> 
                                        <span name="" class="side-icon icon-material-outline-access-time text-lg mr-2"></span> 1 Hour Time 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" lg:-mx-4 mt-6">
                <div class="">
                    <div class="divide-y tube-card px-6 md:m-0 -mx-5 py-1">
                                
                        <div class="md:space-x-6 py-2">
                            <div class="md:pt-0 pt-4"> 
                                <p class="text-lg font-semibold line-clamp-2 leading-8">Python Programming 6 Mid Exam</p>
                                <div class="d-flex justify-between">
                                    <div>
                                        <p class="line-clamp-2">Mid Sem Exam Start</p>  
                                    </div>
                                    <div class="grid md:gap-6 gap-3">
                                        <a class="bg-blue-600 text-white flex font-medium items-center justify-center py-1 px-3 rounded-md hover:text-white" href="">
                                            <span class="md:block hidden">Start Exam </span><span class="md:hidden block">Review</span>
                                            <span class="icon-material-outline-arrow-forward text-lg"></span>
                                        </a>
                                    </div>  
                                </div>
                                <div class="flex items-center text-sm">
                                    <span name="" class="side-con icon-feather-book-open text-lg mr-2"></span>
                                    <div class="flex items-center">Toal Question 20</div>
                                    <div class="flex items-center mx-4"> 
                                        <span name="" class="side-icon icon-material-outline-access-time text-lg mr-2"></span> 1 Hour Time 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- footer -->
        <div class="lg:mt-28 mt-10 mb-7 px-12 border-t pt-7">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <p class="capitalize font-medium"> © copyright 2023  EducateNXT</p>
                <div class="lg:flex space-x-4 text-gray-700 capitalize hidden">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>

    <!-- Main Contents -->
@endsection
<!-- End Content-->

@endsection
