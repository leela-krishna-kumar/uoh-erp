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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="switch d-inline m-r-10">
                                                    <label for="date">Date</label>
                                                    <input type="date"class="form-control" id="date" name="date"value="{{$row->date}}">
                                                    <label for="date" class="cr"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="direction" class="mb-2">Direction</label>
                                            <div class="form-group">
                                              <div class="form-group d-inline">
                                                <div class="radio radio-success d-inline">
                                                    <input type="radio" name="direction" value="1" id="in" @if($row->direction == 1) checked @endif required>
                                                    <label for="in" class="cr">{{ __('In') }}</label>
                                                </div>
                
                                                <div class="radio radio-danger d-inline">
                                                    <input type="radio" name="direction" value="2" id="out" @if($row->direction == 2) checked @endif required>
                                                    <label for="out" class="cr">{{ __('Out') }}</label>
                                                </div>
                
                                                <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('Direction') }}
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="note">Note</label>
                                            <textarea type="text" class="form-control" name="note" id="note" rows="7" >{{ $row->note }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('Note') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
            <!-- [ Card ] end -->
    </div>
        <!-- [ Main Content ] end -->
</div>
<!-- End Content-->
<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $('#tags').tagsinput('items');
</script>

@endsection