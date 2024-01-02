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
                          <input type="hidden" name="placement_id" value="{{request()->get('placement_id')}}">
                            <!-- Form Start -->
                            <fieldset class="row scheduler-border">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="student_id">{{ __('Student') }} <span>*</span></label>
                                        <select class="form-control select2" name="student_id" id="student_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($students as $student)
                                            <option value="{{ $student->student_id }}"> {{ $student->first_name }} {{ $student->last_name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_student_id') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="package">{{ __('Package') }} (in LPA)<span>*</span></label>
                                        <input type="number" class="form-control" name="package" id="package" value="" required placeholder="Enter Package">

                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('Package') }}
                                        </div> 
                                    </div>
                                </div>
                               <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="note">{{ __('Note') }}</label>
                                        <textarea type="text" class="form-control" name="note" id="note"  rows="5" placeholder="Enter Note here.."></textarea>
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Note') }}
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
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

@section('page_js')
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {

            }
        });
    </script>


<!-- Filter Search -->
@endsection