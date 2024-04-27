@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
<style>
    .checkbox{
        border: 2px solid #b4b4b4;
        height: 20px;
        width: 20px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 5px;
        border-radius: 7px;
        -webkit-transition: 0.3s;
        transition: 0.3s;
        left: 0;
        top: 1px;
    }
</style>
 
     <!-- Main Contents -->
        <div class="main_content">
            <div class="overflow-auto overflow-line">
                <div class="max-w-3xl mt-lg-11 mx-auto lg:p-10 p-5 tube-card">

                    <div class="text-center mt-4 mb-6 lg:mt-10">
                        <h1 class="font-semibold md:text-3xl text-xl text-center uk-heading-line"><span>Disclaimer</span></h1>
                    </div>
                    <h3 class="text-lg font-semibold mb-3">Please carefully read the following terms and conditions before participating in the {{$testPaper->title}}:</h3>
                    <article class="space-y-2 uk-article">
                            <div>
                                <ul class="grid md:grid-cols-2">
                                    <li> <i class="uil-check text-xl font-bold mr-2"></i>Total Question {{$testPaper->testPaperQuestions ? $testPaper->testPaperQuestions->count() : '0'}}</li>
                                    <li> <i class="uil-check text-xl font-bold mr-2"></i>Time: {{$formatted_duration}}</li>
                                </ul>
                            </div>
                            @if($testPaper->disclaimer)
                            <div>
                                <h3 class="font-medium text-lg mb-2 mt-4"> Please Read all Conditions Carefully: </h3>
                                {!!$testPaper->disclaimer!!}
                            </div>
                            @endif
                    </article>
                    <form action="{{route('student.student-exam-started',$testPaper->id)}}" method="post">
                        @csrf
                    <div class="row mt-3">
                        <div class="cols-span-2 my-2">
                            <input type="checkbox" name="accept" id="use_points" required class="checkbox">
                            <label for="use_points" class="text-sm"><span class="checkbox-icon"></span> I agree to the <span class="font-semibold">Terms and Conditions</span> </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-block mx-auto md:mt-5">
                            <button type="submit" class="bg-blue-600 text-white flex font-medium items-center justify-center py-3 px-5 rounded-md hover:text-white">
                                <span class="md:block hidden">I am Ready</span>
                                <i class="icon-feather-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- footer -->
            <div class=" mt-10 mb-7 px-12 border-t pt-7">
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
            </div>
        </div>

    <!-- Main Contents -->
@endsection
<!-- End Content-->

@endsection
