@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')

   <!-- Main Contents -->
   <div class="main_content">
    <div class="container">
        <div class="d-flex justify-between">
            <div class="text-2xl">
                <h1 class="text-3xl font-semibold">{{$testPaper->title}}</h1>
            </div>
            <span class="text-2xl font-light">Result</span>
        </div>
        <div class="d-flex justify-between">
            <div class="mt-3">
                <h3 class="text-2xl font-m">Test Paper Analysis</h3>
            </div>
            <span class="text text-muted mr-5">{{$correctAnswer}}</span>
        </div>
        <div class="row mt-10">
            <div class="col-md-3">
                <span class="bg-blue-400 px-3.5 py-3 rounded shadow text-sm text-white "> Total Question {{count($testPaper->testPaperQuestions)}}</span>
            </div>
            <div class="col-md-3">
                <span class="bg-blue-400 px-3.5 py-3 rounded shadow text-sm text-white"> Correct Question {{$correctAnswer}}</span>
            </div>
            <div class="col-md-3">
                <span class="bg-blue-400 px-3.5 py-3 rounded shadow text-sm text-white"> Incorrect Question {{$inCorrectAnswer}}</span>
            </div>
            <div class="col-md-3">
                <span class="bg-blue-400 px-3.5 py-3 rounded shadow text-sm text-white"> Not Attempted Question {{$notAttempted}}</span>
            </div>
        </div>
        {{-- <div class="row mt-12">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div id="container"></div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12">
                <div class="overflow-auto answer-div" style="max-height: 300px;">
                    <div  id="faq" class="tube-card p-5">
                        <h3 class="text-lg font-semibold mb-3"> Answer Of Question  </h3>
                        <ul uk-accordion="multiple: true" class="divide-y space-y-3">
                            <li class="bg-gray-100 px-4 py-3 rounded-md uk-open">
                                <a class="uk-accordion-title font-semibold text-base" href="#"> Html Introduction </a>
                                <div class="uk-accordion-content mt-3">
                                    <p> The primary goal of this quick start guide is to introduce you to
                                        Unreal
                                        Engine 4`s (UE4) development environment. By the end of this guide,
                                        you`ll
                                        know how to set up and develop C++ Projects in UE4. This guide shows
                                        you
                                    </p>
                                </div>
                            </li>
                            <li class="bg-gray-100 px-4 py-3 rounded-md">
                                <a class="uk-accordion-title font-semibold text-base" href="#"> Your First webpage</a>
                                <div class="uk-accordion-content mt-3">
                                    <p> The primary goal of this quick start guide is to introduce you to
                                        Unreal
                                        Engine 4`s (UE4) development environment. By the end of this guide,
                                        you`ll
                                        know how to set up and develop C++ Projects in UE4. This guide shows
                                        you
                                    </p>
                                </div>
                            </li>
                            <li class="bg-gray-100 px-4 py-3 rounded-md">
                                <a class="uk-accordion-title font-semibold text-base" href="#"> Some Special Tags </a>
                                <div class="uk-accordion-content mt-3">
                                    <p> The primary goal of this quick start guide is to introduce you to
                                        Unreal
                                        Engine 4`s (UE4) development environment. By the end of this guide,
                                        you`ll
                                        know how to set up and develop C++ Projects in UE4. This guide shows
                                        you
                                    </p>
                                </div>
                            </li>
                            <li class="bg-gray-100 px-4 py-3 rounded-md">
                                <a class="uk-accordion-title font-semibold text-base" href="#"> Html Introduction </a>
                                <div class="uk-accordion-content mt-3">
                                    <p> The primary goal of this quick start guide is to introduce you to
                                        Unreal
                                        Engine 4`s (UE4) development environment. By the end of this guide,
                                        you`ll
                                        know how to set up and develop C++ Projects in UE4. This guide shows
                                        you
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection
<!-- End Content-->

@endsection