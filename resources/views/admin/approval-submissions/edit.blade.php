@extends('admin.layouts.master')
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
                    <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{auth()->id()}}">
                        <div class="wizard-sec-bg">
                            @csrf
                            @method('PUT')

                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                                <div class=" form-group col-md-6">
                                    <div class="form-group ">
                                        <label for="link" >{{__('Documents')}}<span class="text-danger">*</span> </label>
                                        <input required="" readonly class="form-control" name="link" type="text" id="link" value="{{$row->link}}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="note">{{ __('field_note') }} <span>*</span></label>
                                    <input type="text" readonly class="form-control" name="note" id="note" value="{{ $row->note }}" required>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_note') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="comment">{{ __('Comment') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="comment" id="comment" value="{{$row->comment}}" required>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_comment') }}
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
                                <div class="form-group col-md-6">
                                <label for="status">{{ __('field_status') }}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach ($statuses as $key => $status)
                                        <option value="{{$key}}" @if( $key == $row->status ) selected @endif>{{ $status['label'] }}</option>
                                        @endforeach
                                    </select>
                                <div class="invalid-feedback"> {{ __('field_status') }}
                                </div>
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
