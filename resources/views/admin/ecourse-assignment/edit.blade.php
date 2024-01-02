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
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div> 
            </div>

            <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="title">{{ __('field_title') }}<span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}" required>

                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_type') }}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="e_course_id">Course<span>*</span></label>
                            <select class="form-control select2" name="e_course_id" id="e_course_id" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach($ecourses as $course)
                                <option value="{{ $course->id }}" @if($course->id == $row->e_course_id) selected @endif> {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="type">Type<span>*</span></label>
                            <input type="text" class="form-control" name="type" id="type" value="{{ $row->type}}" required>

                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_type') }}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="due_date">Date<span>*</span></label>
                            <input type="date" class="form-control" name="due_date" id="due_date" value="{{$row->due_date}}" required>

                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_due_date') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="description">Description<span>*</span></label>
                            <textarea type="text" class="form-control" name="description" id="description" rows="12" required>{{ $row->description}}</textarea>
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_description') }}
                            </div>

                        </div>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
            </div>
            </form>
        
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