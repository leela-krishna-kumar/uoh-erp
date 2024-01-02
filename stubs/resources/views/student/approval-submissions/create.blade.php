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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                      <div class="wizard-sec-bg">
                          @csrf
                            <!-- Form Start -->
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                  <div class="form-group col-md-6">
                                      <label for="note">{{ __('Note') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="note" id="note" value=""required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('note') }}
                                      </div>
                                  </div>
                                  {{-- <div class="form-group col-md-6">
                                      <label for="comment">{{ __('Comment') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="comment" id="comment" value="" required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('comment') }}
                                      </div>
                                      
                                  </div> --}}
                                  <div class="form-group col-md-6">
                                    <label for="category_id">{{ __('Category') }} <span>*</span></label>
                                    <select class="form-control" name="category_id" id="category_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($approvalSubmissionCategory as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Category') }}
                                    </div>
                                </div>
                                  <div class=" form-group col-md-6">
                                    <div class="form-group ">
                                        <label for="link" >{{__(' Document Link')}}<span class="text-danger">*</span> </label>
                                        <input required="" class="form-control" name="link" type="text" id="link" value="">
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="student">{{ __('Approval Teacher') }} <span>*</span></label>
                                    <select class="form-control select2" name="approver_id" id="student" required>
                                        <option readonly value="">{{ __('select') }}</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" >{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                </fieldset>
                              </div>
                            </div>
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