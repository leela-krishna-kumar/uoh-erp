@extends('student.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <form class="needs-validation" action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{auth()->id()}}">
                        <div class="wizard-sec-bg">
                            @csrf
                            @method('PUT')

                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                               
                                <div class="form-group col-md-6">
                                    <label for="note">{{ __('field_note') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="note" id="note" value="{{ $row->note }}" required>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_note') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category_id">{{ __('Category') }} <span>*</span></label>
                                    <select class="form-control" name="category_id" id="category_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($approvalSubmissionCategory as $key => $category)
                                            <option value="{{ $category->id }}" @if($category->id == $row->category_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Category') }}
                                    </div>
                                </div>
                                <div class=" form-group col-md-6">
                                    <div class="form-group ">
                                        <label for="link" >{{__(' Document Link')}}<span class="text-danger">*</span> </label>
                                        <input required="" class="form-control" name="link" type="text" id="link" value="{{$row->link}}">
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="student">{{ __('Approval Teacher') }} <span>*</span></label>
                                    <select class="form-control select2" name="approver_id" id="approver_id" required>
                                        <option readonly value="">{{ __('select') }}</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" @if($teacher->id == $row->approver_id) selected @endif>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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

@endsection
