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
                            <div class="form-group col-md-6">
                                <label for="vehicle_id">{{ __('field_vehicle') }} <span>*</span></label>
                                <select class="form-control" name="vehicle_id" id="vehicle_id" required>
                                    <option value="">{{ __('select') }}</option>
                                    @isset($vehicles)
                                    @foreach( $vehicles as $vehicle )
                                    <option value="{{ $vehicle->id }}" @if($row->vehicle_id == $vehicle->id) selected @endif>{{ $vehicle->number }}</option>
                                    @endforeach
                                    @endisset
                                </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_vehicle') }}
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="driver_id">Driver Name</label>
                                    <select class="form-control" name="driver_id" id="driver_id">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach ($users as $key => $user)
                                        <option value="{{$user->id}}" @if($row->driver_id == $user->id) selected @endif>{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select>
                                <div class="invalid-feedback"> {{ __('field_status') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status"disabled>
                                        @foreach ($statuses as $key => $status)
                                        <option value="{{$key}}"@if($key == 1) selected @endif>{{ $status['label'] }}</option>
                                        @endforeach
                                    </select>
                                <div class="invalid-feedback"> {{ __('field_status') }}
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