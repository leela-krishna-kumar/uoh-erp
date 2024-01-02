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
                          {{-- <content class="form-step"> --}}
                            <!-- Form Start -->
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                  <div class="form-group col-md-6">
                                      <label for="name">{{ __('field_name') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="name" id="name" value="{{ old('field_name') }}" required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_name') }}
                                      </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="name">Chapter <span>*</span></label>
                                      <select class="form-control" name="subject_id" id="subject_id"required>
                                        <option value="" selected>{{ __('Select Subject') }}</option>
                                        @foreach ($subjects as $key => $subject)
                                            <option value="{{$subject->id}}">{{ $subject->title }}</option>
                                        @endforeach
                                    </select>
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} Subject
                                      </div>
                                  </div>

                                  <div class="form-group col-md-6">
                                      <label for="start_date">{{ __('field_start_date') }} <span>*</span></label>
                                      <input type="date" class="form-control" name="start_date" id="start_date" min="{{now()->format('Y-m-d')}}" value="{{now()->format('Y-m-d')}}" required>

                                      <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_start_date') }}
                                      </div>
                                  </div>

                                  <div class="form-group col-md-6">
                                      <label for="end_date">{{ __('field_end_date') }} <span>*</span></label>
                                      <input type="date" class="form-control" name="end_date"value="{{ old('end_date') }}" required>

                                      <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_end_date') }}
                                      </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="note">{{ __('field_note') }}</label>
                                      <textarea name="note" id="note" rows="6"class="form-control"></textarea>
                                      <div class="invalid-feedback">{{ __('field_note') }}
                                      </div>
                                  </div>

                                  <div class="form-group col-md-6">
                                    <label for="status">{{ __('field_status') }}</label>
                                        <select class="form-control" name="status" id="status">
                                            {{-- <option value=""selected>{{ __('select') }}</option> --}}
                                            @foreach ($statuses as $key => $status)
                                            <option value="{{$key}}">{{ $status['label'] }}</option>
                                            @endforeach
                                        </select>

                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
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

        $('#start_date').on('change', function(){
            var start_date = $(this).val();
            $('#end_date').val(start_date);
        });
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