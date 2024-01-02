<!DOCTYPE html>
<html lang="en">

<head> 
    @include('student.layouts.common.student_header_script')
</head>

<body>
    <div id="wrapper" class="is-verticle">
        <!-- Start Content-->
        @yield('content')
        <!-- End Content-->
        @include('student.layouts.common.student_footer_script')
</body>

</html>
