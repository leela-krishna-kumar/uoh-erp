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
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                        <div class="wizard-sec-bg">
                          @csrf
                            <!-- Form Start -->
                            <fieldset class="row scheduler-border"> 
                                <div class="row">
                                    <div class="col-md-6">  
                                        <div class="form-group col-md-12">
                                            <label for="title">{{ __('Title') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="title" id="title" value=""required>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <label for="sequence">{{ __('Sequence') }}<span>*</span></label>
                                        <input type="number" class="form-control" name="sequence" id="sequence" value="{{ old('sequence') }}" min="0" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <label for="e_course_id">{{ __('Courses') }} <span>*</span></label>
                                        <select class="form-control select2" name="e_course_id" id="e_course_id" required>
                                            <option readonly value="">{{ __('Select Course ') }}</option>
                                            @foreach($ecourses as $ecourse)
                                            <option value="{{ $ecourse->id }}">{{ $ecourse->title }} </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label for="short_description">{{ __('Description') }}<span>*</span></label>
                                            <textarea name="short_description" id="short_description" class="form-control" required  rows="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
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
