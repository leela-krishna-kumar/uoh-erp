@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection
@push('head')
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.css') }}">
    <style>
        .bootstrap-tagsinput {
            width: 100%;
        }
    </style>
@endpush

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
                        <form class="needs-validation" novalidate action="{{ route($route . '.store') }}" method="post"
                            enctype="multipart/form-data">
                            <div class="card-block">
                                @csrf
                                <!-- Form Start -->
                                <fieldset class="scheduler-border">
                                    <div class="col-md-12 row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">{{ __('field_company') }} <span>*</span></label>
                                                <select class="form-control select2" name="company_id" id="company_id"
                                                    required>
                                                    <option value="">{{ __('Select Company') }}</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}"
                                                            @if (old('company_id') == $company->id) selected @endif>
                                                            {{ $company->name }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_company') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date" class="form-label">Date of Visit
                                                    <span>*</span></label>
                                                <input type="date" class="form-control" name="date" id="date"
                                                    value="{{ old('date') }}" required>

                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_date') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deadline_date" class="form-label"> Application Deadline </label>
                                                <input type="date" class="form-control" name="deadline_date"
                                                    id="deadline_date" value="{{ old('deadline_date') }}">

                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_date') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date" class="form-label">Category <span>*</span></label>
                                                <select class="form-control" name="category_id" id="category_id" required>
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (old('category_id') == $category->id) selected @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_date') }}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="high_school" class="form-label"> High School <span>*</span></label>
                                                <input type="number" required class="form-control" min="0" max="100" name="criteria_description[high_school]"
                                                    id="" value="{{ old('criteria_description[high_school]') }}">
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('High School') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="higher_secondary" class="form-label"> Higher Secondary <span>*</span></label>
                                                <input type="number" required class="form-control" min="0" max="100" name="criteria_description[higher_secondary]"
                                                    id="" value="{{ old('criteria_description[higher_secondary]') }}">
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('Higher Secondary ') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="aggregate" class="form-label"> Aggregate <span>*</span></label>
                                                <input type="number" required class="form-control" min="0" max="100" name="criteria_description[aggregate]"
                                                    id="" value="{{ old('criteria_description[aggregate]') }}">
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('Aggregate') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="required_document" class="form-label"> Document</label>
                                                <input type="text" class="form-control" name="required_document"
                                                    id="tags" value="{{ old('required_document') }}">
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_required_document') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">{{ __('field_description') }}</label>
                                                <textarea type="text" class="form-control" name="description" id="description"rows="5"
                                                    value="{{ old('description') }}"></textarea>

                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_description') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div>
                                                    <input type="checkbox" name="is_event" id="is_event">
                                                    <label for="color"
                                                        class="form-label">{{ __('Would you like to host an event?') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                    {{ __('btn_save') }}</button>
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

@section('page_js')
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            onStepChanging: function(event, currentIndex, newIndex) {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {

            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {

            }
        });
        $('#tags').tagsinput('items');
    </script>


    <!-- Filter Search -->
@endsection
