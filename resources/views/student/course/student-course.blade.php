@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container md:space-y-10 space-y-5">
            
            <div>

                <!-- title -->
                <div class="mb-2">
                    <div class="text-2xl font-semibold mb-3 text-black"> The world's largest selection of courses</div>
                    <!-- <div class="text-xl font-semibold text-dark">  The world's largest selection of courses  </div> -->
                    <div class="text-sm mt-2">  Choose from 130,000 online video courses with new additions published every month </div>
                </div>

                <!-- nav -->
                <nav class="cd-secondary-nav border-b md:m-0 -mx-4 nav-small">
                    <ul>
                        <li class="active"><a href="#" class="lg:px-2">   Python </a></li>
                        <li><a href="#" class="lg:px-2"> Web development </a></li>
                        <li><a href="#" class="lg:px-2"> JavaScript  </a></li>
                        <li><a href="#" class="lg:px-2"> Softwares  </a></li>
                        <li><a href="#" class="lg:px-2"> Drawing  </a></li>
                    </ul>
                </nav>

                <!--  slider -->
                <div class="mt-3">

                    <h4 class="py-3 border-b font-semibold text-grey-700  mx-1 mb-4" hidden> <ion-icon name="star"></ion-icon> Featured today </h4>

                    <div class="relative" uk-slider="finite: true">
            
                        <div class="uk-slider-container px-1 py-3">
                            
                            <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-small uk-grid">
                                @foreach ($e_courses as $e_course)
                                    <li>
                                        <a href="student-courses" class="uk-link-reset">
                                            <div class="card uk-transition-toggle">
                                                <div class="card-media h-40">
                                                    <div class="card-media-overly"></div>
                                                    <img src="{{asset('uploads/ecourse/'.$e_course->image)}}" alt="" class="">
                                                    {{-- <img src="../assets/images/courses/img-1.jpg" alt="" class=""> --}}
                                                    {{-- <span class="icon-play"></span> --}}
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="font-semibold line-clamp-2"> {{$e_course->title}} </div>
                                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                                        <div><i class="fa-regular fa-clock"></i> {{ $e_course->duration ?? 0 }} min</div>
                                                        <span class="mx-2">-</span>
                                                        <div><i class="fa fa-book"></i> {{ $e_course->sections->count() }} Sections</div>
                                                    </div>
                                                    <div class="pt-1 flex items-center justify-between mt-2">
                                                        <div class="text-sm font-medium"><i class="fa-regular fa-user"></i> Created By: {{App\User::where('id', $e_course->created_by)->first()->full_name ?? '--'}} </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- slide icons -->
                            <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                            <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>
    
                        </div>
                    </div>
                
                </div>

            </div>

            <!--  Categories -->
            <div>

                <div class="sm:my-8 my-3 flex items-end justify-between">
                    <div>
                        <h2 class="text-xl font-semibold"> Categories </h2>
                        <p class="font-medium text-gray-500 leading-6"> Find a topic by browsing top categories. </p>
                    </div>
                    <a href="#" class="text-blue-500 sm:block hidden"> See all </a>
                </div> 

                <div class="relative -mt-3" uk-slider="finite: true">
                
                    <div class="uk-slider-container px-1 py-3">
                        <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                            <li>
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="../assets/images/category/design.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Design </div>
                                </div>
                            </li>
                            <li>
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="../assets/images/category/marketing.jpg" class="absolute w-full h-full object-cover"
                                        alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Marketing </div>
                                </div>
                            </li>
                            <li>
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="../assets/images/category/it-and-software.jpg" class="absolute w-full h-full object-cover"
                                        alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Software</div>
                                </div>
                            </li>
                            <li>
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="../assets/images/category/music.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Music </div>
                                </div>
                            </li>
                            <li>
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="../assets/images/category/business.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Travel </div>
                                </div>
                            </li>
                            <li>
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="../assets/images/category/development.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Development </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                    <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                </div>

            </div>

            <div>

                <div class="md:flex justify-between items-center mb-8 pt-4 border-t">

                    <div>
                        <div class="text-xl font-semibold"> Web Development Courses </div>
                        <div class="text-sm mt-2 font-medium text-gray-500 leading-6">  Choose from +10.000 courses with new  additions published every months  </div>
                    </div>

                    <div class="flex items-center justify-end">

                        <div class="bg-gray-100 border inline-flex p-0.5 rounded-md text-lg self-center">
                            <a href="student-courses" class="py-1.5 px-2.5 rounded-md" data-tippy-placement="top" title="List view"> 
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg> 
                            </a>
                            <a href="#" class="py-1.5 px-2.5 rounded-md bg-white shadow" data-tippy-placement="top" title="Grid view"> 
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </a>
                        </div>
                        <a href="#" class="bg-gray-100 border ml-2 px-3 py-2 rounded-md" data-tippy-placement="top"  title="Filter" uk-toggle="target: #course-filter;flip: true"> 
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path></svg>
                        </a>

                    </div>
                </div>
                
                <!-- course list -->
                <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-5">
                    @foreach($e_courses as $e_course)
                        <a href="student-courses" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="../assets/images/courses/img-4.jpg" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2"> {{$e_course->title}}
                                    </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 32 hours </div>
                                        <div>·</div>
                                        <div> lec 4 </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> Created By: {{App\User::where('id', $e_course->id)->first()->full_name ?? '--'}}  </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-9 space-x-2 text-base font-semibold text-gray-400 items-center">
                    <a href="#" class="py-1 px-3 bg-gray-200 rounded text-gray-600"> 1</a>
                    <a href="#" class="py-1 px-2 bg-gray-200 rounded"> 2</a>
                    <a href="#" class="py-1 px-2 bg-gray-200 rounded"> 3</a>
                    <ion-icon name="ellipsis-horizontal" class="text-lg -mb-4"></ion-icon>
                    <a href="#" class="py-1 px-2 bg-gray-200 rounded"> 12</a>
                </div>

            </div>

        </div>

        <!-- footer -->
        <div class="lg:mt-28 mt-10 mb-7 px-12 border-t pt-7">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <p class="capitalize font-medium"> © copyright 2023 EducateNXT</p>
                <div class="lg:flex space-x-4 text-gray-700 capitalize hidden">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
            </div>
        </div>
    </div>

    <!-- course-filter -->
    <div id="course-filter" uk-offcanvas="modee: reveal; overlay: true; flip: true">
        <div class="uk-offcanvas-bar bg-white lg:w-96 w-full overflow-hidden flex justify-between flex-col">

            <div class="px-5 py-2.5 flex items-center space-x-2 shadow-sm">
                <ion-icon name="arrow-back" data-tippy-placement="right" title="Close filter" class="text-xl uk-offcanvas-close relative inset-0 p-0 cursor-pointer"></ion-icon>
                <h3 class="font-semibold text-lg"> Filter </h3>
            </div>
            <div class="p-6 pt-3 flex-1 lg:h-1/6 mr-1" data-simplebar>

                <h3 class="font-semibold text-lg"> Skill Levels  </h3>
                <div> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sediam nibh </div>

                <ul class="ml-2 mb-4 mt-1 -space-y-2">
                    <li class="radio w-full">
                        <input id="radio-1" name="radio" type="radio" checked>
                        <label for="radio-1" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            Beginner <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                    <li class="radio w-full">
                        <input id="radio-2" name="radio" type="radio">
                        <label for="radio-2" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            Entermidate <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                    <li class="radio w-full">
                        <input id="radio-3" name="radio" type="radio">
                        <label for="radio-3" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            Expert <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                </ul>

                <h3 class="font-semibold text-lg"> Pricing  </h3>
                <div> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sediam nibh </div>

                <ul class="ml-2 mb-4 mt-2 -space-y-2">
                    <li class="radio w-full">
                        <input id="Paid-1" name="paid" type="radio" checked>
                        <label for="Paid-1" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            Paid <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                    <li class="radio w-full">
                        <input id="paid-2" name="paid" type="radio">
                        <label for="paid-2" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            Free <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                </ul>

                <h3 class="font-semibold text-lg"> Duration time  </h3>
                <div> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sediam nibh </div>

                <ul class="ml-2 mb-4 mt-2 -space-y-2">
                    <li class="radio w-full">
                        <input id="duration-1" name="duration" type="radio" checked>
                        <label for="duration-1" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            +5 Hourse <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                    <li class="radio w-full">
                        <input id="duration-2" name="duration" type="radio">
                        <label for="duration-2" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            +10 Hourse <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                    <li class="radio w-full">
                        <input id="duration-3" name="duration" type="radio">
                        <label for="duration-3" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            +25 Hourse <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                    <li class="radio w-full">
                        <input id="duration-4" name="duration" type="radio">
                        <label for="duration-4" class="flex justify-between p-2 hover:bg-gray-100 rounded-md" style="padding-left: 20px;">
                            +30 Hourse <span class="radio-label" style="position: relative"></span>
                        </label>
                    </li>
                </ul>

            </div>
            <div class="font-medium gap-2 grid grid-cols-2 text-center p-3 border-t">
                <div class="absolute w-full h-16 -mt-12 bg-gradient-to-b to-transparent from-white"></div>
                <a href="#" class="bg-gray-200 flex-1 py-2.5 rounded-md"> Reset</a>
                <a href="#" class="bg-blue-600 flex-1 py-2.5 rounded-md text-white"> Apply</a>
            </div>

        </div>
    </div>
 
<!-- Main Contents -->
@endsection
<!-- End Content-->

@endsection