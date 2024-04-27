@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
    .input-group-addon{
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.7;
        color: #555;
        text-align: center;
        background-color: #f4f7fa;
        border-bottom: 0.5px solid #ccc;
    }
    
</style>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }} for <span>{{$subject ? $subject->title : ''}}</span></h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <div class="col-sm-12">
                        <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data"id="question-bank">
                            @csrf
                            {{-- <input type="hidden" class="question-value" name="question" value=""> --}}
                            <input type="hidden" name="subject_id" id="subject_id" value="{{request()->get('subject')}}">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <!-- Form Start -->
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="level">{{ __('Question Level') }} <span>*</span></label>
                                                                <select class="form-control" name="level" id="level" required>
                                                                    <option value="">{{ __('Select Level') }}</option>
                                                                    <option value="Easy" >{{ __('Easy') }}</option>
                                                                    <option value="Medium" >{{ __('Medium') }}</option>
                                                                    <option value="Hard" >{{ __('Hard') }}</option>
                                                                </select>
                                
                                                                <div class="invalid-feedback">
                                                                {{ __('required_field') }} {{ __('Question Level') }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="question">{{ __('Question') }} <span>*</span></label>

                                                                <div id="toolbar-container"></div>
                                                                {{-- <div id="txt_area"></div> --}}
                                                                <textarea class="form-control" cols="80" id="info" name="info" rows="10" required></textarea>
                                                                {{-- <textarea class="form-control text-editor" name="info" id="question">{{ old('question') }}</textarea> --}}
                                
                                                                <div class="invalid-feedback">
                                                                {{ __('required_field') }} {{ __('Question') }}
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group col-md-12">
                                                                <label for="status" class="form-label">{{ __('Status') }} <span>*</span></label>
                                                                <select class="form-control" name="status" id="status" required>
                                                                    <option value="">{{ __('Select Status') }}</option>
                                                                    @foreach($statuses as $key => $status)
                                                                        <option value="{{$key}}" selected>{{$status['label']}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                {{ __('required_field') }} {{ __('Status') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="add_question_type" class="form-label">{{ __('Question Type') }} <span>*</span></label>
                                                                <select class="form-control" name="type" id="add_question_type" required onchange="get_question_type(this.value);">
                                                                    <option value=""selected>{{ __('Select Type') }}</option>
                                                                    @foreach($questionTypes as $key => $type)
                                                                        <option value="{{$type['type']}}">{{$type['label']}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                {{ __('required_field') }} {{ __('Question Type') }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12 d-none fn_add_total_option">
                                                                <label for="add_total_option" class="form-label">{{ __('Total Option') }} <span>*</span></label>
                                                                <select class="form-control" name="options"  id="add_total_option" required onchange="get_question_option(this.value);">
                                                                    <option value="">{{ __('Select') }}</option>
                                                                    @for ($i = 1; $i < 7; $i++)
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                {{ __('required_field') }} {{ __('Option') }}
                                                                </div>
                                                            </div>
        
                                                            <div class="fn_add_question_option_block"> 
                                                            </div>
        
                                                            <div class="form-group d-none show-boolean">
                                                                <label for="options">{{ __('Correct Answer') }}</label><span>*</span> 

                                                                <div class="radio-primary d-inline">
                                                                    <input type="radio" id="true" name="correct_options" value="0">
                                                                    <label for="true">True</label>
                                                                  </div>
                                                              
                                                                  <div class="radio-primary d-inline">
                                                                    <input type="radio" id="false" name="correct_options" value="1">
                                                                    <label for="false">False</label>
                                                                  </div>
                            
                                                                <div class="invalid-feedback">
                                                                  {{ __('required_field') }} {{ __('Option') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Form End -->
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/decoupled-document/ckeditor.js"></script>
<script type="text/javascript">
    "use strict";
        let editor;
        $(window).on('load', function (){
            $('#txt_area').addClass('ck-editor');
                DecoupledEditor
                .create( document.querySelector('.ck-editor'),{
                    ckfinder: {
                        uploadUrl: "{{route('admin.question-bank.ckeditor.upload').'?_token='.csrf_token()}}",
                    }
                })
                .then( newEditor => {
                    editor = newEditor;
                    const toolbarContainer = document.querySelector( '#toolbar-container' );
        
                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                } )
                .catch( error => {
                    console.error( error );
                } );

        }); 
        
        $('.onclick-event').on('click',function(){
            $('.question-value').val(editor.getData());
            $('#question-bank').submit();

        });
    

function get_question_type(q_type){
    $('.fn_add_question_option_block').html('');  
    $('#add_total_option').prop('selectedIndex', 0);
    
    if(q_type == 'single' || q_type == 'multi' || q_type == 'blank'){
        $('.fn_add_total_option').removeClass('d-none'); 
    }else if(q_type == 'boolean'){
        $('.fn_add_total_option').addClass('d-none'); 
        $('.show-boolean').removeClass('d-none');
    }else{
        $('.fn_add_total_option').addClass('d-none');    
        $('.fn_add_question_option_block').html('');      
    }
}

function get_question_option(total_option){
    var subject_id = $('#subject_id').val();       
    var question_type = $('#add_question_type').val();  
    if(!subject_id){
       toastr.error('Select Subject');
       return false;
    }
   var question_type = $('#add_question_type').val();
    $.ajax({       
        type   : "GET",
        url    : "{{route('admin.get-question-option')}}",
        data   : {subject_id:subject_id,total_option:total_option,question_type:question_type},               
        async  : false,
        success: function(response){                                                
            if(response)
            {
                $('#add_total_option').prop('selectedIndex', total_option);
                $('.fn_add_question_option_block').html(response);                  
            }
        }
    });   
}
$('#add_question_type').on('change',function(){
    let value = $(this).val();
    if(value == 'boolean'){
        $('#add_total_option').prop('required',false)
    }else{
        $('#add_total_option').prop('required',true)
    }
});



</script>
@endsection