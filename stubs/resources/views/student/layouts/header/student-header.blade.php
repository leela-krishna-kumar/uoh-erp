

<!--  Header  -->
<header uk-sticky> 
    <div class="header_inner">
        <div class="left-side">

            <!-- Logo -->
            <div id="logo">
                <a href="student-dashboard">
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
                {{-- <a href="#" class="header_widgets">
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
                    <a href="#" class="see-all">See all</a>
                </div> --}}
                <a href="{{route('student.chat.index')}}" class="header_widgets">
                    <ion-icon name="chatbubble-ellipses-outline" class="is-icon"></ion-icon>
                </a>

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
                                    <div> {{ auth()->user()->name }} </div>
                                    <span> {{ auth()->user()->email }} </span>
                                </div>
                            </a>
                        </li>
                        <li> 
                            <hr>
                        </li>
                        {{-- <li> 
                            <a href="#">
                                <ion-icon name="person-circle-outline" class="is-icon"></ion-icon>
                                 My Account 
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{route('student.student-account-setting-general')}}">
                                <ion-icon name="settings-outline" class="is-icon"></ion-icon>
                                Account Settings
                            </a>
                        </li>
                        <li> 
                            <hr>
                        </li>
                        <li> 
                            <a href="javascript:void(0);"class="dud-logout" href="{{ route('student.logout') }}"onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <ion-icon name="log-out-outline" class="is-icon"></ion-icon>
                                Log Out 
                            </a>
                            <form id="logout-form" action="{{ route('student.logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div> 

            </div>

        </div>
    </div>
</header>