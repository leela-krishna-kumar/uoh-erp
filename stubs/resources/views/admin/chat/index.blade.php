@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
    .no-pointer{
        cursor: text !important;
    }
    .chat-list-height{
        min-height: 385px;
    }
    .message-content-inner{
        max-height: 385px;
        overflow: auto;
    }
</style>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-4 bg-white">
                <div class="d-flex justify-content-between mt-1">
                    <div class="chat-title">
                        <h4 class="text-muted fw-bold mt-2">Chats</h4>
                    </div>
                    <div class="edit-user mb-1" style="display: inherit;">
                        {{-- <div class="input-group search my-2" id="select_user_box" style="display:none;">
                            <select name="chat_user" id="addChatUser" class="form-control" style=" width: 45vh;">
                                <option value="" readonly>{{ __('Select user to start chat')}}</option>
                                @foreach ($participants as $user)
                                    <option value="{{ $user->id }}" data-name="{{ $user->first_name }}">#CEUID{{ $user->id }} {{ $user->first_name }} <span>( {{ $user->role }})</span></option> 
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class="input-group search my-2" id="select_student_box" style="display:none;">
                            <select name="chat_user" id="addChatUser" class="form-control" style=" width: 45vh;">
                                <option value="" readonly>{{ __('Select student to start chat')}}</option>
                                @foreach ($participants as $user)
                                    <option value="{{ $user->id }}" data-name="{{ $user->first_name }}">#CEUID{{ $user->id }} {{ $user->first_name }} <span>( {{ $user->role }})</span></option> 
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <button type="button" id="hideUserDropdown" class="d-none btn btn btn-light my-2 mx-2" style="padding: 6px 10px;" title="Close Pdf"><i class="fa fa-times mr-0" ></i></button> --}}
                        {{-- <h6 class="text-muted fw-bold">Compose</h6> --}}
                        {{-- <div title="Chat With Student" class="my-2 mx-2" id="add_student_container">
                            <input type="checkbox" name="chat_with_student" id="chat_with_student"> CWS
                        </div> --}}
                       
                        <button title="Select User" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#composeModal">Compose</button>
                    </div>
                </div>
                <hr class="chat-line">
                <div id="chat_area"> 
                    @include('admin.chat.chat_area')
                </div>
                
            </div>
            <div class="col-md-8 bg-white d-none" id="user_chat_area" >
                <div class="d-flex justify-content-between mx-4 mt-3">
                    <div>
                        <h4 id="chat-user" class="text-muted fw-bold">Stella Johnson</h4>
                    </div>
                    {{-- <div class="delete-chat">
                        <i class="fa fa-ellipsis-vertical fs-5"></i>
                    </div> --}}
                </div>
                <hr class="chat-line">
                
                
                <div class="overflow-auto chat-box">
                    <div class="text-center mb-4">
                    </div>
                    <div class="message-content-scrolbar">
                        <div id="user_chat_list"class="chat-list-height">
                        </div>
                        <form action="{{route('admin.conversation.store')}}" method="POST" id="ajaxForm"enctype="multipart/form-data">    
                            @csrf
                            <input type="hidden" name="chat_room_id" value="" id="chat_room_id">
                            <input type="hidden" id="user_id"name="user_id" value="{{ auth()->id() }}" >
                            <input type="hidden" id="receiver_id"name="receiver_id" value="" >
                            <div class="message-reply border-top">
                                <textarea name="message" cols="1" rows="1"class="no-pointer" placeholder="Your Message" id="message" required></textarea>
                                <button type="submit" class="btn bg-primary text-white mt-1">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="composeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Select Participant To Start Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Form Start -->
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
                <form class="needs-validation" novalidate method="POST" action="{{ route("admin.get-role-student") }}" id="filterStudentForm" style="display: none;">
                    @csrf
                    <div class="row gx-2">
                       @include('common.inc.student_search_filter')
                        <div class="form-group col-md-3">
                            <button type="submit" id="filter_student" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                        </div>
                    </div>
                </form>
                <div class="form-group" id="user_container" style="display: none;">
                    <label for="name" class="form-label">{{ __('Participant') }} <span>*</span></label>
                    <select name="chat_user" id="chat_user" class="form-control" required>
                        <option value="" readonly>{{ __('Select user to start chat')}}</option>
                        {{-- @foreach ($participants as $user)
                            <option value="{{ $user->id }}" data-name="{{ $user->first_name }}">#CEUID{{ $user->id }} {{ $user->first_name }} <span>( {{ $user->role }})</span></option> 
                        @endforeach --}}
                    </select>

                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('field_name') }}
                    </div>
                </div>
                <!-- Form End -->
            </div>
            <div class="modal-footer">
                <button type="submit" id="addChatUser" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Start Chat') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Content-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#add_user').click(function(){
        var chat_with_student = $('#chat_with_student').prop('checked');
        if(chat_with_student == false){
            $('#select_user_box').show();
            $('#select_student_box').hide();
            $('#hideUserDropdown').removeClass('d-none');
            $('.chat-title').addClass('d-none');
            $('#add_student_container').hide();
            $('#add_user').hide();
        }else{
            $('#select_student_box').show();
            $('#select_user_box').hide();
            $('#add_student_container').hide();
            $('#hideUserDropdown').removeClass('d-none');
            $('.chat-title').addClass('d-none');
            $('#add_user').hide();
        }
        
    });
    $('#hideUserDropdown').click(function(){
        $('#search_box').show();
        $('#select_user_box').hide();
        $('#select_student_box').hide();
        $('#hideUserDropdown').addClass('d-none');
        $('.chat-title').removeClass('d-none');
        $('#add_user').show();
        $('#add_student_container').show();
    });
     //add chat users
    // $('#addChatUser').on('change', function() {
    //     var receiver_id = $(this).find(":selected").val();
    //     var name = $(this).find(":selected").data('name');
    //     $('#user_id').val(receiver_id);
    //     $.ajax({
    //         url: '{{ route("admin.chat-room-user") }}',
    //         method: 'GET',
    //         data: {receiver_id:receiver_id},
    //         success: function(res) {
    //             if(res){
    //                 $('#chat_area').html(res)
    //             }
    //             $('#user_chat_area').removeClass('d-none');
    //             $('#user_chat_area').show();
    //             // $('#user_chat_area').removeClass('d-none');
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


    $('#addChatUser').on('click', function() {
        var receiver_id = $('#chat_user').find(":selected").val();
        var role_id = $('#role_id').find(":selected").val();
        var name = $(this).find(":selected").data('name');
        $('#user_id').val(receiver_id);
        $.ajax({
            url: '{{ route("admin.chat-room-user") }}',
            method: 'GET',
            data: {receiver_id:receiver_id,role_id:role_id},
            success: function(res) {
                $('#chat_user').val('');
                $('#chat_user').html(`<option value="" readonly>{{ __('Select Participant to Start Chat')}}</option>`);
                $('#role_id').val('');
                $('#user_container').hide();
                $('.btn-close').trigger('click');
                $('#filterStudentForm').hide();
                if(res){
                    $('#chat_area').html(res)
                }
                $('#user_chat_area').removeClass('d-none');
                $('#user_chat_area').show();
                // $('#user_chat_area').removeClass('d-none');
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
     //add chat users
     $('#role_id').on('change', function() {
        var role_id = $(this).find(":selected").val();
        $('#user_container').hide();
        if(role_id == 0){
            $('#filterStudentForm').show();
        }else{
            $('#filterStudentForm').hide();
            $.ajax({
                url: '{{ route("admin.get-role-user") }}',
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

        //add chat users
        $('#filterStudentForm').on('submit',function(e){
            e.preventDefault();
            var route = $(this).attr('action');
            data = new FormData(this);
            $.ajax({
                type: "POST",
                url: route,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    $('#user_container').show();
                    result = $('#chat_user').html(res).css('width','100%').select2();
                },
            });
        });


    //for access users chat area
    function userChatArea(user_id,name){
        $('#chat-user').html($('#user_name'+user_id).data('name'));
        $('#receiver_id').val(user_id);
        $('#message').val('');
        chat_room_id = $('#chat_room_id'+user_id).val();
        user_id = $('#user_id'+user_id).val();
        $('#chat_room_id').val(chat_room_id);
        $('#user_chat_area').show();
        $('#user_chat_area').removeClass('d-none');
        callAjaxChatArea(chat_room_id,user_id);
    }

     //get personal chat area
    function callAjaxChatArea(chat_room_id,user_id){
        $.ajax({
            url: '{{ route("admin.user-chat") }}',
            method: 'GET',
            data: {chat_room_id:chat_room_id,user_id:user_id},
            success: function(res) {
                if(res){
                    $('#user_chat_list').html(res)
                    // setTimeout(function() {
                    //     var scroll=$('.card-body');
                    //     scroll.animate({scrollTop: scroll.prop("scrollHeight")});
                    //     var scroll=$('#user-chat-list');
                    //     scroll.animate({scrollTop: scroll.prop("scrollHeight")});
                    // }, 500);
                }
            }
        })
    }

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

    $(".faculty").on('change',function(e){
      e.preventDefault(e);
      var program=$(".program");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-program') }}",
        data:{
          _token:$('input[name=_token]').val(),
          faculty:$(this).val()
        },
        success:function(response){
              console.log("Okk");
            // var jsonData=JSON.parse(response);
            $('option', program).remove();
            $('.program').append('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.program');
            });
          }

      });
    });

    $(".program").on('change',function(e){
      e.preventDefault(e);
      var session=$(".session");
      var semester=$(".semester");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-session') }}",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', session).remove();
            $('.session').append('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.session');
            });
          }

      });

      $.ajax({
        type:'POST',
        url: "{{ route('filter-semester') }}",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', semester).remove();
            $('.semester').append('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.semester');
            });
          }

      });
    });

    $(".semester").on('change',function(e){
      e.preventDefault(e);
      var section=$(".section");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-section') }}",
        data:{
          _token:$('input[name=_token]').val(),
          semester:$(this).val(),
          program:$('.program option:selected').val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', section).remove();
            $('.section').append('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.section');
            });
          }

      });
    });
    $("#subjectId").on('change',function(e){
      e.preventDefault(e);
      var subjectId = $("#subjectId").val();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-question-subject') }}",
        data:{
          _token:$('input[name=_token]').val(),
          subject_id:subjectId,
        },
        success:function(response){
          $('option', subjectId).remove();
            $('.question').html('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.question
              }).appendTo('.question');
            });
          }

      });
    });
</script>
@endsection
