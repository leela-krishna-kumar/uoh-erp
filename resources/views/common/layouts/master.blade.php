<!DOCTYPE html>
<html lang="en">

<head> 
    @include('common.layouts.common.header_script')
    <style>
        .is-verticle header .header_inner .right-side {
            width: 100%;
            max-width: 100%;
        }
        .is-verticle header .header_inner .left-side {
            width: 0px;
        }
        .main_content {
            margin-left: 0px;
        }
        .posted_by_img{
            width: 50px;
            height: 50px;       
        }
        select, textarea, input, input[type="text"], input[type="password"], input[type="email"], input[type="number"] {
            height: 38px;
            background: #f4f7fa;
        }
        .main_content .container {
            max-width: 100%;
        }
        header.uk-sticky.uk-sticky-fixed {
            display: none;
        }
        .ajax-container{
       
        }
    </style>
</head>

<body>

    <div id="wrapper" class="is-verticle">
        <!--  Header  -->
        @if(!isset($disableHeader))
            @include('common.layouts.common.header')
        @endif    
        <!-- Start Content-->
        @yield('content')
        <!-- End Content-->
        @include('common.layouts.common.footer_script')
</body>

</html>
