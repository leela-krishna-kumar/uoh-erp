
@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@push('head')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.css') }}">
    <style>
        .bootstrap-tagsinput{
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
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                      <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                          <div class="wizard-sec-bg">
                              @csrf
                              @method('PUT')

                              <div class="row">
                              <div class="col-md-12">
                              <fieldset class="row scheduler-border">
                                <div class="col-md-6"> 
                                  <div class="form-group">
                                    <label for="status">{{ __('field_company') }}</label>
                                    <select class="form-control" name="company_id" id="company_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" @if($row->company_id == $company->id) selected @endif>{{ $company->name }}</option>
                                        @endforeach
                                    </select>
            
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_company') }}
                                    </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="date" class="form-label">{{ __('field_date') }} <span>*</span></label>
                                      <input type="date" class="form-control" name="date" id="date" value="{{$row->date}}" required>
              
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_date') }}
                                      </div>
                                  </div>
                                 
                                    <div class="form-group">
                                      <label for="required_document" class="form-label"> Document</label>
                                      <input type="text" class="form-control" name="required_document" id="tags" value="{{$row->required_document}}">
                  
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_required_document') }}
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="deadline_date" class="form-label">Application Deadline</label>
                                        <input type="date" class="form-control" name="deadline_date" id="deadline_date" value="{{ $row->deadline_date }}">
                
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_date') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="description">{{ __('field_description') }}</label>
                                      <textarea type="text" class="form-control" name="description" id="description"rows="8" value="{{ old('description') }}">{{$row->description}}</textarea>
              
                                      <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_description') }}
                                      </div>
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
@endsection
<!-- End Content-->
@section('page_js')
<script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $('#tags').tagsinput('items');
</script>
@endsection


    




