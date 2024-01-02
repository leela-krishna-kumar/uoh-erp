@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')

     <div class="main_content">
      <div class="container">
          <div class="flex flex-col items-center justify-center mt-16">
              <ion-icon name="checkmark-circle" class="hydrated mb-4 md text-9xl text-green-500" role="img" aria-label="checkmark circle"></ion-icon>
          </div>
          <div class="row">
              <div class="d-block mx-auto">
                  <h3 class="text-3xl thank-heading">Submitted Successfully!</h3>
              </div>
          </div>
          <div class="row">
              <div class="d-block mx-auto">
                 <span class="thank-description">Congratulations you have successfully completed <b>{{$testPaper->title}}</b> paper</span>
              </div>
          </div>

          <!-- <div class="text-center mt-10">
              <a class="w-44 d-block mx-auto bg-blue-600 text-white flex font-medium items-center justify-center py-3 rounded-md hover:text-white" href="">
                  <span class="md:block hidden">Access Report
                          <i class="icon-feather-chevron-right"></i>
                  </span>
              </a>

              <div class="mt-10" >
                  <a href=""><i class="icon-feather-chevron-left"></i>  Go Back to Testpapers</a>
              </div>
          </div> -->
          <div class="row">
              <div class="d-block mx-auto md:mt-10">
                  <a class="bg-blue-600 text-white flex font-medium items-center justify-center py- rounded-md hover:text-white" href="{{route("student.student-exam-report",$testPaper->id)}}" style="padding: 12px 30px;">
                      <span class="md:block hidden">Access Report</span>
                      <i class="icon-feather-chevron-right ml-1"></i>
                  </a>
              </div>
          </div>
          {{-- <div class="row">
              <div class="d-block mx-auto md:mt-5">
                  <a class="text-dark flex font-medium items-center justify-center rounded-md" href="exam-show.html" style="padding: 12px 30px;">
                      <i class="icon-feather-chevron-left mr-1"></i>
                      <span class="md:block hidden">Go Back to Testpapers</span>
                  </a>
              </div>
          </div> --}}
      </div>
  </div>
@endsection
<!-- End Content-->

@endsection