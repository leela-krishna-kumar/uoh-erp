@extends('admin.layouts.master')
@section('title', $title)
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
                    @csrf
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->

                        {{-- <div class="form-group col-md-4">
                            <label for="name">{{ __('field_user_name') }} <span>*</span></label>
                            <input type="text" class="form-control" name="user_id" id="user_id" value="{{ old('user_id') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_user_name') }}
                            </div>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label for="activity">{{ __('field_user_activity') }}</label>
                            <input type="text" class="form-control" name="activity" id="activity" value="{{ old('activity') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_user_activity') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="ip_address">{{ __('field_user_ip_address') }}<span class="text-danger">*</span></label>
                            <input required type="text" class="form-control" name="ip_address" id="ip_address" value="{{ old('phone') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_user_ip_address') }}
                            </div>
                        </div>

                              <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="type">{{ __('field_user_type') }}<span class="text-danger">*</span></label>
                                        <select name="type" id="type" class="form-control select2">
                                            <option value="" readonly>Select Type</option>
                                            @foreach ($types as $key=> $types)
                                                <option value="{{$key}}">{{$types['label']}}</option>
                                            @endforeach               
                                                                                    
                                        </select>
                                    </div>
                                </div>
                        <!-- Form End -->
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