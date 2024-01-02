@extends('student.layouts.student-master')
@section('content')
<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">     

    <!-- Main Contents -->
    <div class="main_content">
        <span uk-toggle="target: .message-content;" class="fixed left-0 top-36 bg-red-600 z-10 py-1 px-4 rounded-r-3xl text-white"> Users</span>
        <div class="messages-container">
            <div class="messages-container-inner">
                <div class="messages-inbox">
                    <div class="messages-headline">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="text-muted fw-bold mt-2">Chats</h4>
                            </div>
                            <div class="edit-user mb-1" style="display: inherit;margin-left: 10px;">
                                <div class="input-group search my-2" id="select_user_box" style="display:none;">
                                    <select name="chat_user" id="addChatUser" class="form-control">
                                        <option value="" readonly>{{ __('Select user to start chat')}}</option>
                                        @foreach ($participants as $user)
                                            <option value="{{ $user->id }}" data-name="{{ $user->first_name }}">#CEUID{{ $user->id }} {{ $user->first_name }}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <h6 class="text-muted fw-bold">Compose</h6> --}}
                                <button title="add user" id="add_user1" type="button" class="btn btn-primary"uk-toggle="target: #composeModal" >Compose</button>
                                <button type="button" id="hideUserDropdown" class="d-none btn btn btn-light my-2 mx-2" style="padding: 6px 10px;" title="Close Pdf"><i class="fa fa-times mr-0" ></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="messages-inbox-inner" data-simplebar>
                        <ul>
                            <div id="chat_area"> 
                                @include('student.chat.chat_area')
                            </div>
                            {{-- <li class="active-message">
                                <a href="#">
                                    <div class="message-avatar"><i class="status-icon status-offline"></i><img src="../assets/images/avatars/avatar-2.jpg" alt=""></div>

                                    <div class="message-by">
                                        <div class="message-by-headline">
                                            <h5>Adrian Mohani</h5>
                                            <span>Yesterday</span>
                                        </div>
                                        <p>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore</p>
                                    </div>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="message-content d-none">

                    <div class="messages-headline">
                        <h4 id="chat-user"> Stella Johnson </h4>
                        {{-- <a href="#" class="message-action text-red-500"><i class="icon-feather-trash-2"></i> <span class="md:inline hidden"> Delete Conversation</span> </a> --}}
                    </div>
                    
                    <div class="message-content-scrolbar" data-simplebar>
                        <div class="message-content-inner">
                                <div id="user_chat_list">
                                    {{-- @include('student.chat.private-chat-list') --}}
                                </div>
                                {{-- <div class="message-bubble">
                                    <div class="message-bubble-inner">
                                        <div class="message-avatar"><img src="../assets/images/avatars/avatar-2.jpg" alt=""></div>
                                        <div class="message-text">
                                            <!-- Typing Indicator -->
                                            <div class="typing-indicator">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> --}}
                        </div>
                        <!-- Reply Area -->
                        <form action="{{route('student.conversation.store')}}" method="POST" id="ajaxForm"enctype="multipart/form-data">    
                            @csrf
                            <input type="hidden" name="chat_room_id" value="" id="chat_room_id">
                            <input type="hidden" id="user_id"name="user_id" value="{{ auth()->id() }}" >
                            <input type="hidden" id="receiver_id"name="receiver_id" value="" >
                            <div class="message-reply border-top">
                                <textarea name="message" cols="1" rows="1" placeholder="Your Message" id="message" required></textarea>
                                <button type="submit" class="btn bg-primary text-white mt-1">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div id="composeModal" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Select Participant To Start Chat</h2>
            </div>
            <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                <div class="uk-modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('Select Role') }} <span>*</span></label>
                            <select class="form-control" name="role_id" id="role_id" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach($roles as $key => $role)
                                    @if($key === $roles->keys()->last())
                                        <option value="0">{{ __('field_student') }}</option>
                                    @endif
                                    <option value="{{ $role->id }}" @if(old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
        
                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_name') }}
                            </div>
                        </div>
                        <div class="form-group" id="user_container" style="display: none;">
                            <label for="name" class="form-label">{{ __('Participant') }} <span>*</span></label>
                            <select name="chat_user" id="chat_user" class="form-control" required>
                                <option value="" readonly>{{ __('Select user to start chat')}}</option>
                            </select>
        
                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_name') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-modal-footer text-right">
                    <button type="submit" id="addChatUser" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Start Chat') }}</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#add_user').click(function(){
            $('#select_user_box').show();
            $('#hideUserDropdown').removeClass('d-none');
            $('#add_user').hide();
        });
        $('#hideUserDropdown').click(function(){
            $('#search_box').show();
            $('#select_user_box').hide();
            $('#hideUserDropdown').addClass('d-none');
            $('#add_user').show();
        });
        //  //add chat users
        // $('#addChatUser').on('change', function() {
        //     var receiver_id = $(this).find(":selected").val();
        //     var name = $(this).find(":selected").data('name');
        //     $('#user_id').val(receiver_id);
        //     $.ajax({
        //         url: '{{ route("student.chat-room-user") }}',
        //         method: 'GET',
        //         data: {receiver_id:receiver_id},
        //         success: function(res) {
        //             if(res){
        //                 $('#chat_area').html(res)
        //             }
        //             $('.message-content').show();
        //             $('.message-content').removeClass('d-none');
        //             setTimeout(function() {
        //                 $('#chat-user').html($('#user_name'+receiver_id).data('name'));
        //                 chat_room_id = $('#chat_room_id'+receiver_id).val();
        //                 $('#chat_room_id').val(chat_room_id);
        //                 $('#user-chat-time').html($('#updated_at'+receiver_id).val());
        //                 user_id = $('#user_id'+receiver_id).val();
        //                 callAjaxChatArea(chat_room_id,user_id);
        //             }, 500);
        //         }
                
        //     })
        // });
    
          //add chat users
          $('#addChatUser').on('click', function() {
            var receiver_id = $('#chat_user').find(":selected").val();
            var name = $(this).find(":selected").data('name');
            $('#user_id').val(receiver_id);
            $.ajax({
                url: '{{ route("student.chat-room-user") }}',
                method: 'GET',
                data: {receiver_id:receiver_id},
                success: function(res) {
                    $('#chat_user').val('');
                    $('#chat_user').html(`<option value="" readonly>{{ __('Select Participant to Start Chat')}}</option>`);
                    $('#role_id').val('');
                    $('#user_container').hide();
                    $('.uk-modal-close-default').trigger('click');
                    $('#filterStudentForm').hide();
                    if(res){
                        $('#chat_area').html(res)
                    }
                    $('.message-content').show();
                    $('.message-content').removeClass('d-none');
                    setTimeout(function() {
                        $('#chat-user').html($('#user_name'+receiver_id).data('name'));
                        chat_room_id = $('#chat_room_id'+receiver_id).val();
                        $('#chat_room_id').val(chat_room_id);
                        $('#user-chat-time').html($('#updated_at'+receiver_id).val());
                        user_id = $('#user_id'+receiver_id).val();
                        callAjaxChatArea(chat_room_id,user_id);
                    }, 500);
                }
                
            })
        });
    
        //for access users chat area
        function userChatArea(user_id,name){
            $('#chat-user').html($('#user_name'+user_id).data('name'));
            $('#receiver_id').val(user_id);
            $('#message').val('');
            chat_room_id = $('#chat_room_id'+user_id).val();
            user_id = $('#user_id'+user_id).val();
            $('#chat_room_id').val(chat_room_id);
            $('.message-content').show();
            $('.message-content').removeClass('d-none');
            callAjaxChatArea(chat_room_id,user_id);
        }
    
         //get personal chat area
        function callAjaxChatArea(chat_room_id,user_id){
            $.ajax({
                url: '{{ route("student.user-chat") }}',
                method: 'GET',
                data: {chat_room_id:chat_room_id,user_id:user_id},
                success: function(res) {
                    if(res){
                        $('#user_chat_list').html(res)
                    }
                }
            })
        }

          //add chat users
        $('#role_id').on('change', function() {
            var role_id = $(this).find(":selected").val();
            $('#user_container').hide();
            if(role_id == 0){
                $('#filterStudentForm').show();
            }else{
                $('#filterStudentForm').hide();
                $.ajax({
                    url: '{{ route("student.get-role-user") }}',
                    method: 'GET',
                    data: {role_id:role_id},
                    success: function(res) {
                        if(res){
                            $('#user_container').show();
                            result = $('#chat_user').html(res).css('width','100%').select2();
                        }
                    }
                    
                })
            }
        });
        
        $('#ajaxForm').on('submit',function(e){
            e.preventDefault();
            var route = $(this).attr('action');
            type = $('#chat_type').val();
            chat_room_id = $('#chat_room_id').val();
            data = new FormData(this);
            $.each($("input[type=file]"), function(i, obj) {
                    $.each(obj.files,function(j, file){
                        data.append('file['+j+']', file);
                    })
            });
            // data.append( "file", $("#file")[0].files[0]);
            $.ajax({
                type: "POST",
                url: route,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    $('#user_chat_list').html(res);
                    $('#message').val('');
                    $(".input-wrap").css("padding-right", "120px");
                    $('#file').val('');
                    $('.showFile').show();
                    $('#file').hide();
                    $('#message').show();
                    $('#file').prop('required',false);
                    $('#message').prop('required',true);
                    if(type == 'GroupChat'){
                        $('#group_chat_list').show();
                        $('#user_chat_list').hide();
                        $('#group_chat_list').html(res)
                    }else{
                        $('#group_chat_list').hide();
                        $('#user_chat_list').show();
                        $('#user_chat_list').html(res)
                    }
                    chatListSearch();
                    setTimeout(function() {
                        $('.card-body').animate({scrollTop: $('.card-body').prop("scrollHeight")});
                        var scroll=$('#user-chat-list');
                        scroll.animate({scrollTop: scroll.prop("scrollHeight")});
                    }, 10);
                },
            });
        });
    </script>
    <!-- Main Contents -->
@endsection

