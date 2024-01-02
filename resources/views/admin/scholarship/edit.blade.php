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
                                    <label for="title">Title<span>*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_title') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="donor_id">Scholarship Provider Name<span>*</span></label>
                                    <select class="form-control select2" name="donor_id" id="donor_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($donors as $donor)
                                        <option value="{{ $donor->id }}" @if($donor->id == $row->donor_id) selected @endif>{{ $donor->donor_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Donor Name') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="received_amount">Received Amount<span>*</span></label>
                                    <input type="number" class="form-control" name="received_amount" id="received_amount" value="{{$row->received_amount }}"  min="0" required>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Received Amount') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-6">
                                        <label for="from_date">From Date<span>*</span></label>
                                        <input type="date" class="form-control" name="from_date" id="from_date" value="{{$row->from_date}}" required>
    
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_from_date') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="to_date">To Date<span>*</span></label>
                                        <input type="date" class="form-control" name="to_date" id="to_date" value="{{$row->to_date}}" required>
    
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_to_date') }}
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="note">Note<span>*</span></label>
                                    <textarea type="text" class="form-control" name="note" id="note" rows="12" required>{{$row->note}}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_note') }}
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