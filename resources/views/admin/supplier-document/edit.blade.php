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

                    <div class="card-block">
                        <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="item_supplier_id" value="{{ request()->get('supplier_id') }}">
                              <!-- Form Start -->
                              <div class="row">
                                  <div class="form-group col-md-4">
                                      <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required="">
                                      <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div>
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label for="type" class="form-label">{{ __('field_type') }} <span>*</span></label>
                                      <select class="form-control" name="type_id">
                                          <option value="" readonly="">Select Document Type</option>
                                          @foreach ($types as $type)
                                            <option value="{{ $type->id }}" @if($row->type_id == $type->id) selected @endif>{{ $type->name }}</option>
                                          @endforeach
                                      </select>
                                      <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_type') }}</div>
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label for="document" class="form-label">{{ __('field_document') }} <span>*</span></label>
                                      <input type="file" class="form-control" name="document" id="document" value="" required="">
                                      <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_document') }}</div>
                                  </div>
                              </div>
                            <div class="card-footer">
                              <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                          </div>
                      </form>
                    </div>
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
<!-- Filter Search -->
@endsection