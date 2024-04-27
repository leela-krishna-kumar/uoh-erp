@extends('student.layouts.student-master')
@section('content')

<!-- Start Content-->
@section('content')
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">

            <h3 class="text-2xl font-medium mb-5"> Account Settings </h3>

            <nav class="cd-secondary-nav border-b md:m-0 -mx-4 nav-small">
                <ul>
                    <li><a href="{{route('student.student-account-setting-general')}}" class="lg:px-2">General </a></li>
                    <li class="active"><a href="#"> Privacy </a></li>
                </ul>
            </nav>
           
            <div class="nav-item">
                <!-- Change Password -->
                <div class="grid lg:grid-cols-3 gap-8 md:mt-12">
                    <div>
                        <div uk-sticky="offset:100;bottom:true;media:992">
                            <h3 class="text-lg mb-2 font-semibold"> Password</h3>
                            <p> Lorem ipsum dolor sit amet nibh consectetuer adipiscing elit</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-md lg:shadow-md shadow col-span-2">
                        
                        <div class="lg:p-6 p-4 space-y-4">
                            <div>
                                <label for="current_password"> Current password</label>
                                <input type="text" placeholder="" id="current_password" class="shadow-none with-border" value="{{ Crypt::decryptString($row->password_text) }}">
                            </div>
                            <div>
                                <label for="new_password"> New password</label>
                                <input type="text" placeholder="" id="new_password" class="shadow-none with-border">
                            </div>
                            <div>
                                <label for="confirm_new_password"> Confirm new password</label>
                                <input type="text" placeholder="" id="confirm_new_password" class="shadow-none with-border">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        @include('student.layouts.footer.student-footer')
    </div>
    <!-- Main Contents -->
@endsection

@endsection