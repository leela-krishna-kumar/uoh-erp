@extends('admin.layouts.master')
@section('title', $title)
@section('content')

@push('head')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.css') }}">
    <style>
        .bootstrap-tagsinput{
            width: 100%;
        }
    </style>
@endpush
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} <span class="fw-bolder fst-italic">{{@$row->student->first_name}} {{@$row->student->last_name}}'s</span> {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-block">
                        <div class="row">
                            <!-- Form Start -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}" required>
            
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_title') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="tags">{{ __('field_tags') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="tags" id="tags" value="{{$row->tags}}" required >
            
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_tags') }}
                                            </div>
                                        </div>
            
                                        <div class="form-group col-md-12">
                                            <label for="project_category_id">{{ __('Category') }} <span>*</span></label>
                                            <select class="form-control" name="project_category_id" id="project_category_id">
                                                <option value="">{{ __('select') }}</option>
                                                @foreach($project_categories as $category)
                                                    <option value="{{ $category->id }}"@if($row->project_category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
            
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('Category') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="subject_id">{{ __('field_subject') }} <span>*</span></label>
                                            <select class="form-control select2" name="subject_id" id="subject_id" required>
                                                  <option value="">{{ __('select') }}</option>
                                                  @foreach($subjects as $subject )
                                                        <option value="{{ $subject->id }}" @if($row->subject_id == $subject->id) selected @endif>{{ $subject->code }} - {{ $subject->title }}</option>
                                                  @endforeach
                                            </select>
                          
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_subject') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="status">{{ __('Status') }} <span>*</span></label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($statuses as $key => $status)
                                                    <option value="{{$key}}" @if($row->status == $key) selected @endif>{{$status['label']}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('Status') }}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                               <div class="d-flex justify-content-between">
                                                    <label for="dissertation">{{ __('field_dissertation') }} <span>*</span>
                                                    <small class="text-primary">(To update attachment upload new)</small></label>
                                                    <a target="_blank" class="text-primary" href="{{ asset('uploads/project/'.$row->dissertation) }}">View Attachment</a>
                                               </div>
                                                <input type="file" class="form-control" name="dissertation" id="dissertation">
            
                                                <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_dissertation') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="description">{{ __('field_description') }} <span>*</span></label>
                                            <textarea type="text" class="form-control" name="description" id="description"rows="8">{{$row->description}}</textarea>
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_description') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4"></div>
                            <!-- Form End -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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
<script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $('#tags').tagsinput('items');
</script>

@endsection