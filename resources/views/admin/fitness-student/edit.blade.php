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
                        <h5>{{ __('modal_edit') }} <span class="fw-bolder fst-italic">{{@$row->student->first_name}} {{@$row->student->last_name}}'s</span> {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-block row">
                    <div class="col-md-6">
                            <label for="date">{{ __('Age') }} <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[age]" id="payload[age]" value="{{ $row->payload['age'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Age') }}
                            </div>
                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">{{ __('Height') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[height]" id="payload[height]" value="{{ $row->payload['height'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Height') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">{{ __('Weight') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[weight]" id="payload[weight]" value="{{ $row->payload['weight'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Weight') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">{{ __('Fat') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[fat]" id="payload[fat]" value="{{ $row->payload['fat'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Fat') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">{{ __('BMI') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[bmi]" id="payload[bmi]" value="{{ $row->payload['bmi'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('BMI') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">{{ __('RM(Resting Metabolism)') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[rm]" id="payload[rm]" value="{{ $row->payload['rm'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('RM(Resting Metabolism)') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">{{ __('VF(Visceral Fat)') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="form-control autonumber" name="payload[vf]" id="payload[vf]" value="{{ $row->payload['vf'] }}" data-v-max="999999999" data-v-min="0">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('VF(Visceral Fat)') }}
                            </div>
                        </div>
                            <div class="form-group col-md-6">
                                <label for="status">{{ __('Sports') }}</label>
                                <select class="form-control select2" name="sports_ids[]" id="sports_id" multiple>
                                    <option value=""readonly>{{ __('Select Sports') }}</option>
                                    @foreach ($sports as $key => $sport)
                                        <option value="{{$sport->id}}" @if($row->sports_ids && in_array($sport->id, $row->sports_ids)) selected @endif>{{ $sport->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Sports') }}
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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
<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $('#tags').tagsinput('items');
</script>

@endsection