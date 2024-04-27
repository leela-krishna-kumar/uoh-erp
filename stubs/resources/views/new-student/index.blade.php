<!DOCTYPE html>
<html lang="en">

<head> 

    <!-- Basic Page Needs
    ================================================== -->
    <title>Courseplus Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Courseplus is - Professional A unique and beautiful collection of UI elements">

    <!-- Favicon -->
    <link href="../assets/images/favicon.png" rel="icon" type="image/png">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="../assets/css/icons.css">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="../assets/css/uikit.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper" class="is-verticle">

        <!--  Header  -->
        <header uk-sticky> 
            <div class="header_inner">
                <div class="left-side">
    
                    <!-- Logo -->
                    <div id="logo">
                        <a href="explore.html">
                            <img src="../assets/images/logo.png" alt="">
                            <img src="../assets/images/logo-light.png" class="logo_inverse" alt="">
                            <img src="../assets/images/logo-mobile.png" class="logo_mobile" alt="">
                        </a>
                    </div>
    
                     <!-- icon menu for mobile -->
                     <div class="triger" uk-toggle="target: #wrapper ; cls: is-active">
                    </div>
    
                </div>
                <div class="right-side">
     
                    <!-- Header search box  -->
                    <div class="header_search"><i class="uil-search-alt"></i> 
                        <input value="" type="text" class="form-control" placeholder=" Quick search for anything.." autocomplete="off">
                        <div uk-drop="mode: click;offset:10" class="header_search_dropdown">
                               
                            <h4 class="search_title"> Recently </h4>
                            <ul>
                                <li> 
                                    <a href="#">  
                                        <img src="../assets/images/avatars/avatar-1.jpg" alt="" class="list-avatar">
                                        <div class="list-name">  Erica Jones </div>
                                    </a> 
                                </li> 
                                <li> 
                                    <a href="#">  
                                        <img src="../assets/images/avatars/avatar-2.jpg" alt="" class="list-avatar">
                                        <div class="list-name">  Coffee  Addicts </div>
                                    </a> 
                                </li>
                                <li> 
                                    <a href="#">  
                                        <img src="../assets/images/avatars/avatar-3.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Mountain Riders </div>
                                    </a> 
                                </li>
                                <li> 
                                    <a href="#">  
                                        <img src="../assets/images/avatars/avatar-4.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Property Rent And Sale  </div>
                                    </a> 
                                </li>
                                <li> 
                                    <a href="#">  
                                        <img src="../assets/images/avatars/avatar-5.jpg" alt="" class="list-avatar">
                                        <div class="list-name">  Erica Jones </div>
                                    </a> 
                                </li>
                            </ul>
    
                        </div>
                    </div>
                    
                    <div>
        
                        <!-- notification -->
                        <a href="#" class="header_widgets">
                            <ion-icon name="mail-outline" class="is-icon"></ion-icon>
                        </a>
                        <div uk-drop="mode: click" class="header_dropdown"> 
                            <div class="drop_headline">
                                <h4>Messages</h4>
                                <div class="btn_action">
                                    <div class="btn_action">
                                        <a href="#">
                                            <ion-icon name="settings-outline" uk-tooltip="title: Notifications settings ; pos: left"></ion-icon>
                                        </a>
                                        <a href="#">
                                            <ion-icon name="checkbox-outline" uk-tooltip="title: Mark as read all ; pos: left"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <ul class="dropdown_scrollbar" data-simplebar>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-1.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <strong> John menathon </strong> <span class="time"> 6:43 PM</span>
                                            <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-2.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <strong> Zara Ali </strong> <span class="time">12:43 PM</span>
                                            <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-3.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <strong> Mohamed Ali </strong> <span class="time"> Wed</span>
                                            <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-1.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <strong> John menathon </strong> <span class="time"> Sun </span>
                                            <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-2.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <strong> Zara Ali </strong> <span class="time"> Fri </span>
                                            <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-3.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <strong> Mohamed Ali </strong> <span class="time">1 Week ago</span>
                                            <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <a href="transcript.html" class="see-all">See all</a>
                        </div>
        
                        <!-- messages -->
                        <a href="#" class="header_widgets">
                            <ion-icon name="notifications-outline" class="is-icon"></ion-icon>
                            <span> 2 </span>
                        </a>
                        <div uk-drop="mode: click" class="header_dropdown">
                            <div class="drop_headline">
                                <h4>Notifications</h4>
                                <div class="btn_action">
                                    <a href="#">
                                        <ion-icon name="settings-outline" uk-tooltip="title: Message settings ; pos: left"></ion-icon>
                                    </a>
                                    <a href="#">
                                        <ion-icon name="checkbox-outline" uk-tooltip="title: Mark as read all ; pos: left"></ion-icon>
                                    </a>
                                </div>
                            </div>
                            <ul class="dropdown_scrollbar" data-simplebar>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-1.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <p> <strong>Adrian Mohani</strong> Like Your Comment On Course
                                                <span class="text-link">Javascript Introduction </span>
                                            </p>
                                            <span class="time-ago"> 2 hours ago </span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-2.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <p>
                                                <strong>Stella Johnson</strong> Replay Your Comments in
                                                <span class="text-link">Programming for Games</span>
                                            </p>
                                            <span class="time-ago"> 9 hours ago </span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-3.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <p>
                                                <strong>Alex Dolgove</strong> Added New Review In Course
                                                <span class="text-link">Full Stack PHP Developer</span>
                                            </p>
                                            <span class="time-ago"> 12 hours ago </span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="../assets/images/avatars/avatar-1.jpg" alt="">
                                        </div>
                                        <div class="drop_content">
                                            <p>
                                                <strong>Jonathan Madano</strong> Shared Your Discussion On Course
                                                <span class="text-link">Css Flex Box </span>
                                            </p>
                                            <span class="time-ago"> Yesterday </span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <a href="#" class="see-all">See all</a>
                        </div>
        
                         <!-- profile -->
                        <a href="#">
                            <img src="../assets/images/avatars/placeholder.png" class="header_widgets_avatar" alt="">
                        </a>
                        <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">
                            <ul>   
                                <li>
                                    <a href="#" class="user">
                                        <div class="user_avatar">
                                            <img src="../assets/images/avatars/avatar-2.jpg" alt="">
                                        </div>
                                        <div class="user_name">
                                            <div> Stella Johnson </div>
                                            <span> @Johnson </span>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <hr>
                                </li>
                                <li> 
                                    <a href="#">
                                        <ion-icon name="person-circle-outline" class="is-icon"></ion-icon>
                                         My Account 
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <ion-icon name="settings-outline" class="is-icon"></ion-icon>
                                        Account Settings  
                                    </a>
                                </li>
                                <li> 
                                    <hr>
                                </li>
                                <li> 
                                    <a href="#">
                                        <ion-icon name="log-out-outline" class="is-icon"></ion-icon>
                                        Log Out 
                                    </a>
                                </li>
                            </ul>
                        </div> 

                    </div>
    
                </div>
            </div>
        </header>
         
        <!-- Main Contents -->
        <div class="main_content">
            <div class="container">
                        <div class="mt-0">
        
                            <!-- title -->
                            <div class="mb-2">
                                <div class="text-2xl font-semibold mb-3 text-black">  B.Tech IT   </div>
                                <div class="text-sm mt-2">  Choose from 130,000 online video courses with new additions published every month </div>
                            </div>
        
                            <!-- nav -->
                            <nav class="cd-secondary-nav border-b md:m-0 -mx-4 nav-small">
                                <ul>
                                    <li class="active"><a href="#" class="lg:px-2">   Semester 1 </a></li>
                                    <li><a href="#" class="lg:px-2"> Semester 2 </a></li>
                                    <li><a href="#" class="lg:px-2"> Semester 3  </a></li>
                                    <li><a href="#" class="lg:px-2"> Semester 4  </a></li>
                                    <li><a href="#" class="lg:px-2"> Semester 5 </a></li>
                                    <li><a href="#" class="lg:px-2"> Semester 6 </a></li>
                                </ul>
                            </nav>
                        </div>
        
                        <div>
                            <div class="md:flex justify-between items-center mb-8 pt-4 border-t">
        
                                <div>
                                    <div class="text-xl font-semibold"> Web Development Courses </div>
                                    <div class="text-sm mt-2 font-medium text-gray-500 leading-6">  Choose from +10.000 courses with new  additions published every months  </div>
                                </div>
            
                                <div class="flex items-center justify-end">
        
                                    <div class="bg-gray-100 border inline-flex p-0.5 rounded-md text-lg self-center">
                                        <a href="courses-list.html" class="py-1.5 px-2.5 rounded-md" data-tippy-placement="top" title="List view"> 
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
                                
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-4.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2"> Learn Angular Fundamentals From beginning to advance lavel
                                            </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 32 hours </div>
                                                <div>·</div>
                                                <div> lec 4 </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Jesse Stevens  </div>
                                                <!-- <div class="text-lg font-semibold"> $29.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-6.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2">Build Responsive Real World Websites with HTML5 and CSS3 </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 13 hours </div>
                                                <div>·</div>
                                                <div>32 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> John Michael </div>
                                                <!-- <div class="text-lg font-semibold"> $14.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-5.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2">C# Developers Double Your Coding Speed with Visual Studio </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 18 hours </div>
                                                <div>·</div>
                                                <div>42 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Stella Johnson  </div>
                                                <!-- <div class="text-lg font-semibold"> $18.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-1.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2"> Learn JavaScript and Express to become a professional
                                                JavaScript developer. </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 13 hours </div>
                                                <div>·</div>
                                                <div>32 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> John Michael  </div>
                                                <!-- <div class="text-lg font-semibold"> $14.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-2.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2"> Learn and Understand AngularJS to become a professional  developer</div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 26 hours </div>
                                                <div>·</div>
                                                <div>26 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Stella Johnson  </div>
                                                <!-- <div class="text-lg font-semibold"> $18.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-3.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2">Responsive Web Design Essentials HTML5 CSS3 and Bootstrap </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 18 hours </div>
                                                <div>·</div>
                                                <div>42 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Monroe Parker   </div>
                                                <!-- <div class="text-lg font-semibold"> $11.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-1.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2"> Learn JavaScript and Express to become a professional
                                                JavaScript developer. </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 13 hours </div>
                                                <div>·</div>
                                                <div>32 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> John Michael  </div>
                                                <!-- <div class="text-lg font-semibold"> $14.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-2.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2"> Learn and Understand AngularJS to become a professional  developer</div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 26 hours </div>
                                                <div>·</div>
                                                <div>26 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Stella Johnson  </div>
                                                <!-- <div class="text-lg font-semibold"> $18.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="course-intro.html" class="uk-link-reset">
                                    <div class="card uk-transition-toggle">
                                        <div class="card-media h-40">
                                            <div class="card-media-overly"></div>
                                            <img src="../assets/images/courses/img-3.jpg" alt="" class="">
                                            <span class="icon-play"></span>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="font-semibold line-clamp-2">Responsive Web Design Essentials HTML5 CSS3 and Bootstrap </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div> 18 hours </div>
                                                <div>·</div>
                                                <div>42 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Monroe Parker   </div>
                                                <!-- <div class="text-lg font-semibold"> $11.99 </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </a>  
        
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
                <div class="md:p-7 p-5 bg-white rounded-md shadow lg:mt-10 mt-6">

                    <h3 class="md:text-2xl text-xl mt-4 mb-1 font-bold"> Featured More </h3>
                    <p class="mb-8"> Choose Your Favorite Topic</p>
        
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 md:gap-4 gap-2 -m-3">
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="logo-angular" class="text-3xl text-white from-red-600 to-red-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg">Web Development</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 12 Courses </div>
                                        <div>·</div>
                                        <div> 156 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="briefcase" class="text-3xl text-white from-blue-600 to-blue-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Financial Analysis</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 16 Courses </div>
                                        <div>·</div>
                                        <div> 523 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="color-wand" class="text-3xl text-white from-purple-600 to-purple-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Graphic Design</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 23 Courses </div>
                                        <div>·</div>
                                        <div> 356  Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="shield-checkmark" class="text-3xl text-white from-yellow-600 to-yellow-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Ethical Hacking</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 12 Courses </div>
                                        <div>·</div>
                                        <div> 256 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="leaf" class="text-3xl text-white from-green-600 to-green-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Cyber Security</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 34 Courses </div>
                                        <div>·</div>
                                        <div> 420 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="logo-figma" class="text-3xl text-white from-pink-600 to-pink-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Adobe Target</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 14 Courses </div>
                                        <div>·</div>
                                        <div> 259K Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 -m-3 mt-7">
                        
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="briefcase" class="text-3xl text-white from-blue-600 to-blue-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Financial Analysis</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 16 Courses </div>
                                        <div>·</div>
                                        <div> 523 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="color-wand" class="text-3xl text-white from-purple-600 to-purple-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Graphic Design</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 23 Courses </div>
                                        <div>·</div>
                                        <div> 356  Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="shield-checkmark" class="text-3xl text-white from-yellow-600 to-yellow-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Ethical Hacking</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 12 Courses </div>
                                        <div>·</div>
                                        <div> 256 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="logo-angular" class="text-3xl text-white from-red-600 to-red-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg">Web Development</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 12 Courses </div>
                                        <div>·</div>
                                        <div> 156 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="leaf" class="text-3xl text-white from-green-600 to-green-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Cyber Security</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 34 Courses </div>
                                        <div>·</div>
                                        <div> 420 Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="hover:bg-gray-100 flex items-start px-3 py-2 rounded-lg space-x-3">
                                <ion-icon name="logo-figma" class="text-3xl text-white from-pink-600 to-pink-400 bg-gradient-to-tl p-2 rounded-md"></ion-icon>
                                <div>
                                    <h3 class="font-semibold text-lg"> Adobe Target</h3>
                                    <div class="flex space-x-2 items-center text-sm pt-0.5">
                                        <div> 14 Courses </div>
                                        <div>·</div>
                                        <div> 259K Students</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="flex justify-center mt-9">
                        <a href="#" class="bg-gray-50 border hover:bg-gray-100 px-4 py-1.5 rounded-full text-sm"> More Topics ..</a>
                    </div>

                </div>

            </div>

            <!-- footer -->
            <div class="lg:mt-28 mt-10 mb-7 px-12 border-t pt-7">
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
 
        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebar_inner" data-simplebar>
                
                <ul class="side-colored">
                    <li><a href="explore.html">
                            <ion-icon name="compass" class="side-icon"> </ion-icon>
                            <span> Home</span>
                        </a>
                    </li>
                    <li><a href="courses.html">
                            <ion-icon name="play-circle" class="side-icon"> </ion-icon>
                            <span> Courses</span>
                        </a>
                    </li>
                    <li><a href="books.html">
                            <ion-icon name="book" class="side-icon"> </ion-icon>
                            <span> Books </span>
                        </a>
                    </li>
                </ul>

                <ul class="side_links" data-sub-title="Pages">
                    <li><a href="calendar.html"> <span name="" class="side-icon icon-material-outline-date-range"></span>Calendar </a></li>
                    <li><a href="class-routine.html"> <span name="" class="side-icon icon-material-outline-access-time"> </span>Class Routine </a></li>
                    <li><a href="exam-routine.html"> <span name="" class="side-icon icon-material-outline-question-answer"></span> Exam Routine </a></li>
                    <li><a href="attendance.html"> <span  name="" class="side-icon icon-material-outline-assessment"></span> Attendance </a></li>
                    <li><a href="apply-leave.html"> <ion-icon name="receipt-outline" class="side-icon"></ion-icon> Apply Leaves </a></li>
                    <li><a href="fees-report.html"> <span name="" class="side-icon icon-material-outline-description"></span>Fees Reports </a></li>
                    <li><a href="library.html"> <span name="" class="side-icon icon-material-outline-book"></span> Library</a></li>
                    <li><a href="notices.html"> <span name="" class="side-icon icon-feather-file-text"></span> Notices </a></li>
                    <li><a href="assignments.html"> <span name="" class="side-icon icon-material-outline-assignment"></span> Assignments </a></li> 
                    <li><a href="download.html"> <span name="" class="side-icon icon-material-outline-save-alt"></span> Downloads </a></li> 
                    <li><a href="faq.html"> <ion-icon name="albums-outline" class="side-icon"></ion-icon> Faq</a></li>
                    <li><a href="#"><span name="" class="side-icon icon-material-outline-account-circle"></span> My Profile  </a> 
                        <ul>
                            <li><a href="form-login.html">form login </a></li>
                            <li><a href="form-register.html">form register</a></li> 
                        </ul>
                    </li>
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
        <!-- Main Contents -->
 
    <!-- Javascript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../assets/js/uikit.js"></script>
    <script src="../assets/js/tippy.all.min.js"></script>
    <script src="../assets/js/simplebar.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>

</body>

</html>
