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
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                  <div class="form-group col-md-6">
                                      <label for="account_holder_name">{{ __('Account Holder Name') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" value=""required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('account_holder_name') }}
                                      </div>
                                  </div>

                                  <div class="form-group col-md-6 ">
                                    <label for="bank_id" class="form-label">{{ __('Choose Banks') }} <span>*</span></label>
                                    <select   class="form-control select2"  name="bank_id", id="bank_id">
                                        <option value=""> Select Bank Name</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_college_banks') }}
                                    </div>
                                  </div>

                                    <div class="form-group col-md-6 row ">
                                        <label for="">Add Account Type <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input name="type" value="0" type="radio" class="form-check-input pb-1"
                                                    required="" checked>
                                                <label  class="form-check-label pl-2 mb-1 " for="current">Current</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input name="type" value="1" type="radio" class="form-check-input pb-1"
                                                required="">
                                            <label class="form-check-label pl-2 mb-1 " for="saving">Saving</label>
                                            </div>
                                        </div>  
                                    </div>   

                                  <div class="form-group col-md-6" style="margin-left: 24px;">
                                      <label for="account_no">{{ __('Account Number') }} <span>*</span></label>
                                      <input type="number" class="form-control" name="account_no" id="account_no" min="0" value="" required>
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('account_no') }}
                                      </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="ifsc">{{ __('IFSC') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="ifsc" id="ifsc" value="" required>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('ifsc') }}
                                    </div>
                                </div>

                                  <div class="form-group col-md-6">
                                    <label for="branch">{{ __('Branch') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="branch" id="branch" value="" required>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('branch') }}
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