@extends('admin.layouts.master')
@section('title', $title)
@section('content')

@push('head')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.css') }}">
    <style>
        .bootstrap-tagsinput{
            width: 100%;
        }
    </style>
@endpush
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div> 
            </div>

            <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="donar_name">Donar Name<span>*</span></label>
                                        <input type="text" class="form-control" name="donar_name" id="donar_name" value="{{$row->donar_name }}" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="contact_name">Contact Name<span>*</span></label>
                                        <input type="text" class="form-control" name="contact_name" id="contact_name" value="{{$row->contact_name }}" required>
                                    </div>
                                  
                                    <div class="form-group col-md-12">
                                        <label for="donar_type">Donar Type</label>
                                            <select class="form-control" name="donar_type" id="donar_type">
                                                <option value="">{{ __('select') }}</option>
                                                @foreach ($types as $key => $type)
                                                <option value="{{$key}}" @if($key == $row->donar_type) selected @endif>{{ $type['label'] }}</option>
                                                @endforeach
                                            </select>
                                        <div class="invalid-feedback"> {{ __('field_status') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="email">Email<span>*</span></label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{ $row->email }}" required>
    
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_email') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="phone">phone<span>*</span></label>
                                        <input type="number" class="form-control" name="phone" id="phone" value="{{ $row->phone }}" required>
    
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_phone') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="note">Note<span>*</span></label>
                                        <textarea type="text" class="form-control" name="note" id="note" rows="7" required>{{$row->note}}</textarea>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_note') }}
                                        </div>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="address">Address<span>*</span></label>
                                        <textarea type="text" class="form-control" name="address" id="address" rows="7" required>{{$row->address }}</textarea>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_address') }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                         </div>
                         <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                            </div>
                    </div>
                </div>
            </div>
           
                
        
            </form>
        
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $('#tags').tagsinput('items');
</script>

@endsection