<!-- sidebar -->
<div class="sidebar">
    <div class="sidebar_inner" data-simplebar>
        
        <ul class="side-colored">
            <li class="nav-item {{ Request::is('student/student-dashboard*') ? 'active' : '' }}">
                <a href="{{route('student.student-dashboard.index')}}">
                    <ion-icon name="compass" class="side-icon"> </ion-icon>
                    <span> Home</span>
                </a>
            </li>
            
            <li class="nav-item {{ Request::is('student/student-courses*') ? 'active' : '' }}">
                <a href="{{route('student.student-courses')}}">
                    <ion-icon name="play-circle" class="side-icon"> </ion-icon>
                    <span> Courses</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-books*') ? 'active' : '' }}">
                <a href="{{route('student.student-books')}}">
                    <ion-icon name="book" class="side-icon"> </ion-icon>
                    <span> Books </span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-exams-info*') ? 'active' : '' }}">
                <a href="{{route('student.student-exams-info')}}">
                    <ion-icon name="newspaper" class="bg-gradient-to-br from-purple-300 p-1 rounded-md side-icon text-opacity-80 text-white to-blue-500">
                    </ion-icon>
                    <span> Exam</span>
                </a>
            </li>
        </ul>
        
        <ul class="side_links" data-sub-title="Pages">
            <li class="nav-item {{ Request::is('student/student-calender*') ? 'active' : '' }}">
                <a href="{{route('student.student-calender')}}"> <span name="" class="side-icon icon-material-outline-date-range"></span>Calendar </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-class-routine*') ? 'active' : '' }}">
                <a href="{{route('student.student-class-routine')}}"> <span name="" class="side-icon icon-material-outline-access-time"> </span>Class Routine </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-exam-routine*') ? 'active' : '' }}">
                <a href="{{route('student.student-exam-routine')}}"> <span name="" class="side-icon icon-material-outline-question-answer"></span> Exam Routine </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-attendance*') ? 'active' : '' }}">
                <a href="{{route('student.student-attendance')}}"> <span  name="" class="side-icon icon-material-outline-assessment"></span> Attendance </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-apply-leave*') ? 'active' : '' }}">
                <a href="{{route('student.student-apply-leave')}}"> <ion-icon name="receipt-outline" class="side-icon"></ion-icon> Apply Leaves </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-grievance*') ? 'active' : '' }}">
                <a href="{{route('student.student-grievance')}}"> <ion-icon name="receipt-outline" class="side-icon"></ion-icon> Grievance </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-approval-submissions*') ? 'active' : '' }}">
                <a href="{{route('student.student-approval-submissions')}}"> <span  name="" class="side-icon icon-material-outline-question-answer"></span> Submissions </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-library*') ? 'active' : '' }}">
                <a href="{{route('student.student-library')}}"> <span name="" class="side-icon icon-material-outline-book"></span> Library</a>
            </li>
            <li class="nav-item {{ Request::is('student/student-notices*') ? 'active' : '' }}">
                <a href="{{route('student.student-notices')}}"> <span name="" class="side-icon icon-feather-file-text"></span> Notices </a>
            </li>
            <li class="nav-item {{ Request::is('student/student-assignments*') ? 'active' : '' }}">
                <a href="{{route('student.student-assignments')}}"> <span name="" class="side-icon icon-material-outline-assignment"></span> Assignments </a>
            </li> 
            <li class="nav-item {{ Request::is('student/projects') ? 'active' : '' }}">
                <a href="{{route('student.projects.index')}}"> <span name="" class="side-icon icon-material-outline-account-circle"></span> Projects </a>
            </li> 
            <li class="nav-item {{ Request::is('student/counselling') ? 'active' : '' }}">
                <a href="{{route('student.counselling.index')}}"> <span name="" class="side-icon icon-material-outline-book"></span> Counselling </a>
            </li> 
            <li class="nav-item {{ Request::is('student/student-download*') ? 'active' : '' }}">
                <a href="{{route('student.student-download')}}"> <span name="" class="side-icon icon-material-outline-save-alt"></span> Downloads </a>
            </li> 
            {{-- <li><a href="#"> <ion-icon name="albums-outline" class="side-icon"></ion-icon> Faq</a></li> --}}
            {{-- <li><a href="#"><span name="" class="side-icon icon-material-outline-account-circle"></span> My Profile  </a> 
                <ul>
                    <li><a href="#">form login </a></li>
                    <li><a href="#">form register</a></li> 
                </ul>
            </li> --}}
        </ul>
        <div class="side_foot_links">
            <a href="#">About</a>
            <a href="#">Blog </a>
            <a href="#">Careers</a>
            <a href="#">Support</a>
            <a href="#">Contact Us </a>
            <a href="#">Developer</a>
            <a href="#">Terms of service</a>
        </div>
    </div>

    <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>
</div>


