<!DOCTYPE html>
<html lang="en">

<head> 
    @include('student.layouts.common.student_header_script')
</head>

<body>

    <div id="wrapper" class="is-verticle">
            <!--  Header  -->
            @include('student.layouts.header.student-header')
        <!-- Start Content-->
        @yield('content')
        <!-- End Content-->
            @include('student.layouts.inc.student-sidebar')
        @include('student.layouts.common.student_footer_script')
</body>

</html>
