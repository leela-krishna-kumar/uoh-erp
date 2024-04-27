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
                        <h5>{{ __('modal_edit') }} {{ $title }} for <span>{{$subject->title}}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update',$row->id) }}" method="post" id="question-bank"enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden"name="type"value="{{$row->type}}">
                        <input type="hidden" class="question-value" name="question" value="">
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <!-- Form Start -->
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        {{-- <div class="form-group col-md-12">
                                                            <label for="subject_id">{{ __('Subject') }} <span>*</span></label>
                                                            <select class="form-control" name="subject_id" id="subject_id" required>
                                                                <option value="">{{ __('Select Subject') }}</option>
                                                                @foreach($subjects as $key => $subject)
                                                                    <option value="{{$subject->id}}" @if($row->subject_id == $subject->id) selected @endif>{{ $subject->title }}</option>
                                                                @endforeach
                                                            </select>
                            
                                                            <div class="invalid-feedback">
                                                            {{ __('required_field') }} {{ __('Subject') }}
                                                            </div>
                                                        </div> --}}
                                                        <div class="form-group col-md-12">
                                                            <label for="level">{{ __('Question Level') }} <span>*</span></label>
                                                            <select class="form-control" name="level" id="level" required>
                                                                <option value="">{{ __('Select Level') }}</option>
                                                                <option value="Easy"@if($row->level == "Easy") selected @endif>{{ __('Low') }}</option>
                                                                <option value="Medium"@if($row->level == "Medium") selected @endif >{{ __('Medium') }}</option>
                                                                <option value="Hard" @if($row->level == "Hard") selected @endif>{{ __('High') }}</option>
                                                            </select>
                            
                                                            <div class="invalid-feedback">
                                                            {{ __('required_field') }} {{ __('Question Level') }}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="question">{{ __('Question') }} <span>*</span></label>
                                                            <div id="toolbar-container"></div>
                                                                <div id="txt_area">
                                                                    {!!@$row->question!!}
                                                                </div>
                                                            {{-- <textarea class="form-control text-editor" name="question" id="question">{!! $row->question !!}</textarea> --}}
                            
                                                            <div class="invalid-feedback">
                                                            {{ __('required_field') }} {{ __('Question') }}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="title" class="form-label">{{ __('Status') }} <span>*</span></label>
                                                            <select class="form-control" name="status" id="status" required>
                                                                <option value="">{{ __('Select Status') }}</option>
                                                                @foreach($statuses as $key => $status)
                                                                    <option value="{{$key}}" @if($row->status == $key) selected @endif>{{$status['label']}}</option>
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
                                                        @php
                                                            $correct_options = $row->correct_options;
                                                        @endphp
                                                        @if($row->type == 'single' || $row->type == 'multi' || $row->type == 'blank')
                                                            @foreach($options as $key => $option)
                                                                @if($row->type == 'blank')
                                                                    <div class="form-group col-md-12">
                                                                        <label for="checkbox">Answer {{$key+1}}<span>*</span></label>
                                                                        <div class="d-flex">
                                                                            <input type="text"class="form-control" name="options[]" id="checkbox" value="{{$option}}">
                                                                            <span class="input-group-addon">
                                                                                <input type="radio"name="correct_options" class="" value="{{$key+1}}"@if($correct_options == $key+1) checked @endif required>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="form-group col-md-12">
                                                                        <label for="checkbox">Option {{$key+1}}<span>*</span></label>
                                                                        <div class="d-flex">
                                                                            <input type="text"class="form-control"name="options[]" id="checkbox" value="{{$option}}">
                                                                            <span class="input-group-addon">
                                                                                @if($row->type == "multi")
                                                                                <input type="checkbox" name="correct_options[]" value="{{$key+1}}" @if(in_array($key+1,$correct_options)) checked @endif>
                                                                                @else
                                                                                <input type="radio" name="correct_options" class="" value="{{$key+1}}"@if($correct_options == $key+1) checked @endif required>
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                        <div class="form-group">
                                                            <label for="options">{{ __('Correct Option') }}</label><span>*</span><br> <br>
                                                            <div class="radio-primary d-inline">
                                                                <input type="radio" id="true" name="correct_options" value="0"@if($row->correct_options == "0")checked @endif>
                                                                <label for="true">True</label>
                                                              </div>
                                                              <div class="radio-primary d-inline">
                                                                <input type="radio" id="false" name="correct_options" value="1"@if($row->correct_options == "1")checked @endif>
                                                                <label for="false">False</label>
                                                              </div>
                                                            <div class="invalid-feedback">
                                                              {{ __('required_field') }} {{ __('Option') }}
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Form End -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success onclick-event"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                            </div>
                        </div>
                    </form>
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
    <script>
        let editor;
        $(window).on('load', function (){
            $('#txt_area').addClass('ck-editor');
            DecoupledEditor
            .create( document.querySelector('.ck-editor'),{
                ckfinder: {
                    uploadUrl: "",
                }
            })
            .then( newEditor => {
                editor = newEditor;
                const toolbarContainer = document.querySelector( '#toolbar-container' );
    
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            } )
            .catch( error => {
                console.error( error );
            });
        }); 
        $('.onclick-event').on('click',function(){
            $('.question-value').val(editor.getData());
            $('#question-bank').submit();

        });
    </script>
@endsection