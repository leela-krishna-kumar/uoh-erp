 <!-- sidebar -->
 <div class="sidebar bg-white">
           
    <!-- slide_menu for mobile -->
    <span class="btn-close-mobi right-3 left-auto" uk-toggle="target: #wrapper ; cls: is-active"></span>

    <!-- back to home link -->
    <div class="flex justify-between lg:-ml-1 mt-1 mr-2">
        <a href="{{route('student.student-courses-info', $e_course->id)}}" class="flex items-center text-blue-500">
            <ion-icon name="chevron-back-outline" class="md:text-lg text-2xl"></ion-icon>  
            <span class="text-sm md:inline hidden"> back</span>
        </a>
    </div>

    <!-- title -->
    <h1 class="lg:text-2xl text-lg font-bold mt-2 line-clamp-2"> {{$e_course->title}} </h1>

    <nav class="cd-secondary-nav nav-small extanded w-auto lg:block hidden">
        <ul uk-switcher="connect: #course-tabs; animation: uk-animation-fade">
            <li><a href="#" class="lg:px-2">   Lessons </a></li>
            {{-- <li><a href="#" class="lg:px-2">  Notes  </a></li> 
            <li><a href="#" class="lg:px-2"> Faq  </a></li>  --}}
        </ul>
    </nav>

    <hr class="-mx-6 lg:block hidden"> 

    <!-- sidebar list -->
    <div class="sidebar_inner" data-simplebar>
        
        <div class="uk-switcher" id="course-tabs">

            <div id="curriculum"> 
                <div uk-accordion="multiple: true" class="divide-y space-y-3">
                    @if($e_sections->count() > 0)
                        @foreach ($e_sections as $e_section)
                            <div class="pt-2 uk-open">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> 
                                    <div class="mb-1 text-sm font-medium"> 
                                        {{$e_section->title ?? ''}} 
                                    </div>
                                    {{$e_section->short_description ?? ''}} 
                                </a>
                                <div class="uk-accordion-content mt-3">
        
                                    {{-- <ul class="course-curriculum-list" uk-switcher="connect: #video_tabs; animation: uk-animation-fade"> --}}
                                     <ul uk-switcher="connect: #video_tabs; animation: uk-animation-fade">
                                            @php
                                                $e_lessons = App\Models\ELesson::where('e_section_id', $e_section->id)->get();
                                            @endphp
                                            @if($e_lessons->count() > 0)
                                                <input type="hidden" id="is_elesson" name="is_elesson" value="1">
                                                @foreach ($e_lessons as $key => $e_lesson)
                                                        <li>
                                                            <a id="get_link{{$e_lesson->id}}" onclick="getLinkVal({{$e_lesson->id}})" data-type="{{$e_lesson->type}}"
                                                                data-course_id="{{$e_course->id}}" data-lesson_id="{{$e_lesson->id}}" 
                                                                data-student_id="{{$e_course->eCourseUser->first() ? $e_course->eCourseUser->first()->student_id : null}}" data-link="{{$e_lesson->link ?? ''}}">
                                                                @if($e_lesson->type == 0)
                                                                    <i class="fa-solid fa-video"></i> 
                                                                @elseif($e_lesson->type == 1) 
                                                                    <i class="fas fa-icons"></i> 
                                                                @elseif($e_lesson->type == 2)
                                                                    <i class="fas fa-file-alt"></i>
                                                                @elseif($e_lesson->type ==3)
                                                                    <i class="fas fa-newspaper"></i> 
                                                                @endif
                                                                {{$e_lesson->title ?? ''}} 
                                                            </a>
                                                        </li>
                                                @endforeach
                                            @else
                                            <h5 class="text-center text-muted"> No Lesson Found!</h5>
                                            @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h5 class="text-center text-muted">No Section Found!</h5>
                    @endif
                </div>
            </div>

            <!--  Overview -->
            <div class="space-y-6 px-2 py-6">
                <div>
                    <h3 class="text-lg font-semibold mb-1"> Description </h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                        tincidunt ut
                        laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim laoreet dolore magna
                        aliquam erat
                        volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit
                        lobortis
                        nisl ut aliquip ex ea commodo consequat
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-1"> What You’ll Learn </h3>
                    <ul>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Setting up the environment</li>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Advanced HTML Practices</li>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Build a portfolio website</li>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Responsive Designs</li>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Understand HTML Programming</li>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Code HTML</li>
                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Start building beautiful websites</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-1"> Requirements</h3>
                    <ul class="list-disc ml-5 space-y-1 mt-3">
                        <li>Any computer will work: Windows, macOS or Linux</li>
                        <li>Basic programming HTML and CSS.</li>
                        <li>Basic/Minimal understanding of JavaScript</li>
                    </ul>
                </div>
            </div>

            <!--  Announcements -->
            <div  class="px-2 py-6">
                <h3 class="text-xl font-semibold mb-3"> Announcement </h3>
                
                <div class="flex items-center gap-x-4 mb-5">
                    <img src="../assets/images/avatars/avatar-4.jpg" alt="" class="rounded-full shadow w-10 h-10">
                    <div>
                        <h4 class="-mb-1 text-base"> Stella Johnson</h4>
                        <span class="text-sm"> Instructor <span class="text-gray-500"> 1 year ago </span> </span>
                    </div>
                </div>
            
                <h4 class="leading-8 text-xl"> Nam liber tempor cum soluta nobis eleifend </h4>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolo  sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                    tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis
                    nostrud exerci ta ifend  nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad
                    minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea
                    commodo consequat.</p>
            
            </div>

        </div>


    </div>

    <!-- overly for mobile -->
    <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>

</div>