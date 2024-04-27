@extends('student.layouts.student-master')

@section('content')
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
            <div class="box">
                <div class="box-row">
                    <div class="box-cell box1">
                        <div class="grid lg:grid-cols-3 gap-8 md:mt-12">
                            <!-- Student Information Form -->
                            <div class="bg-white rounded-md lg:shadow-md shadow col-span-2">
                                <form action="{{ url('/student/student-photo-submission') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Student Details -->
                                    <div class="container">
                                        <!-- First Name -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="first-name"> First name</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" placeholder="" id="first-name" class="shadow-none with-border" value="{{$row->first_name}}"  name="first_name">
                                            </div>
                                        </div>
                                        <!-- Last Name -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="last-name"> Last name</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" placeholder="" id="last-name" class="shadow-none with-border" value="{{$row->last_name}}" name="last_name">
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Email</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$row->email}}" name="email">
                                            </div>
                                        </div>
                                        <!-- Contact Number -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="phone"> Contact Number</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" placeholder="" id="phone" class="shadow-none with-border"  value="{{$row->phone}}" name="phone">
                                            </div>
                                        </div>
                                        <!-- Roll Number -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Roll Number</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$row->roll_no}}" disabled>
                                            </div>
                                        </div>
                                        <!-- Faculty -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Faculty</label>
                                            </div>
                                            <div class="col-8">
                                                @php
                                                use Illuminate\Support\Facades\DB;
                                                $faculty = DB::table('faculties')->where('id', $row->faculty_id)->first();
                                                @endphp
                                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$faculty->title}}" disabled>
                                            </div>
                                        </div>
                                        <!-- Program -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Program</label>
                                            </div>
                                            <div class="col-8">
                                                @php
                                                $program = DB::table('programs')->where('id', $row->program_id)->first();
                                                @endphp
                                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$program->title}}" disabled>
                                            </div>
                                        </div>
                                        <!-- Academic Year -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Academic Year</label>
                                            </div>
                                            <div class="col-8">
                                                @php
                                                $session = DB::table('sessions')->where('id', $row->session_id)->first();
                                                @endphp
                                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$session->title}}" disabled>
                                            </div>
                                        </div>
                                        <!-- Semester -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Semester</label>
                                            </div>
                                            <div class="col-8">
                                                @php
                                                $semesters = DB::table('semesters')->where('id', $row->semester_id)->first();
                                                @endphp
                                                <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$semesters->title}}" disabled>
                                            </div>
                                        </div>
                                        <!-- Section -->
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="email"> Section</label>
                                            </div>
                                            <div class="col-8">
                                                @php
                                            $sections = DB::table('sections')->where('id', $row->section_id)->first();
                                            @endphp
                                            <input type="text" placeholder="" id="email" class="shadow-none with-border"  value="{{$sections->title}}" disabled>
                                            </div>
                                        </div>
                                        <!-- Student Photo -->
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <img src="{{ asset('uploads/student/'. $row->photo ) }}" alt="" class="rounded-full" style="width: 100px; height: 100px;">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="membership_file">Photo<span>*</span></label>
                                                <input type="file" class="form-control" name="photo" id="" required>
                                            </div>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="mb-3">
                                            <center><button type="submit" class="btn btn-primary">Save</button></center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- End of Student Information Form -->
                            
                            <!-- Cards -->
                            <div class="col-span-1">
                                <!-- Attendance -->
                                <div class="card mb-4">
                                   <div class="box-cell box2 mb-4">
                                    <a href="{{ url('/student/student-attendance') }}" class="card bg-light-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-black mb-2">Attendance</h5>
                                        </div>
                                    </a>
                                </div> 
                            </div>
                            
                            <div class="col-span-1">
                                <!-- Attendance -->
                                <div class="card mb-4">
                                   <div class="box-cell box2 mb-4">
                                    <a href="{{ url('/student/placements') }}" class="card bg-light-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-black mb-2">Placements</h5>
                                        </div>
                                    </a>
                                </div> 
                            </div>
                               
                                <!-- Syllabus Covered -->
                                <div class="box-cell box2 mb-4">
                                    <div class="card bg-c-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-black mb-2">Syllabus Covered</h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- Events -->
                               <div class="col-span-1">
                                <div class="card mb-4">
                                   <div class="box-cell box2 mb-4">
                                    <a href="{{ url('/student/student-calender') }}" class="card bg-light-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-black mb-2">Events</h5>
                                        </div>
                                    </a>
                                </div> 
                            </div>
                                <!-- Student Warnings -->
                                <div class="box-cell box2 mb-4">
                                    <div class="card bg-c-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-black mb-2">Student Warnings</h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- Counsellor -->
                                <div class="col-span-1">
                                <div class="card mb-4">
                                   <div class="box-cell box2 mb-4">
                                    <a href="{{ url('/student/student-counselling') }}" class="card bg-light-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-black mb-2">Counsellor</h5>
                                        </div>
                                    </a>
                                </div> 
                            </div>
                            </div>
                            <!-- End of Cards -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
