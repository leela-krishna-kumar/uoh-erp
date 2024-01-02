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
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="model_id" value="{{$row->model_id}}">

                        <div class="wizard-sec-bg">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <fieldset class="row scheduler-border">
                                        <div class="col-md-12 row">
                                            <div class=" col-md-6">
                                                <label for="bank_name">{{ __('Bank') }}<span>*</span></label>
                                                    <select class="form-control" name="bank_name" id="bank_name" required>
                                                        <option value="">{{ __('select') }}</option>
                                                        @foreach ($banks_name as $key => $status)
                                                        <option value="{{$key}}" @if($key == $row->bank_name) selected @endif >{{ $status['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                <div class="invalid-feedback"> {{ __('Banks') }}
                                                </div>
                                            </div>

                                            <div class=" col-md-6">
                                                <label for="status">{{ __('Status') }}<span>*</span></label>
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value="">{{ __('select') }}</option>
                                                        @foreach ($statuses as $key => $status)
                                                        <option value="{{$key}}" @if($key == $row->status) selected @endif >{{ $status['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                <div class="invalid-feedback"> {{ __('Status') }}
                                                </div>
                                            </div>
                                            <div class="co-md-6 row  mt-3">
                                                <label  for="">Add Account Type <span>*</span></label>
                                                <div class="col-md-3">
                                                    <div class="form-check ">
                                                        <input name="type" value="Current" type="radio" class="form-check-input pb-1" required="" @if(@$row->payload['type'] == 'Current') checked @endif>
                                                        <label class="form-check-label pl-2 mb-1 " for="current">Current</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-check mb-2">
                                                        <input name="type" value="Saving" type="radio" class="form-check-input pb-1" required="" @if(@$row->payload['type'] == 'Saving') checked @endif>
                                                        <label class="form-check-label pl-2 mb-1 " for="saving">Saving</label>
                                                    </div>
                                                </div>
                                              </div>

                                            <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                                <label for="phone" class="control-label">{{ 'Account Holder Name' }}<span
                                                        >*</span></label>
                                                <input name="account_holder_name" required type="text" pattern="[a-zA-Z]+.*"
                                                    title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control"
                                                    placeholder="Enter Account Holder Name"
                                                    value="{{$row->payload['account_holder_name']}}">
                                            </div>
                                            
                                          
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('account_no') ? 'has-error' : '' }}">
                                                <label for="account_no" class="control-label">{{ 'Account Number' }}<span
                                                        >*</span></label>
                                                <input name="account_no" required type="number" min="0" id="numberInput"
                                                    class="form-control " placeholder="Enter Account Number" value="{{$row->payload['account_no']}}">
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('ifsc_code') ? 'has-error' : '' }}">
                                                <label for="ifsc_code" class="control-label">
                                                    {{ 'IFSC Code' }}<span>*</span>
                                                </label>
                                                <input name="ifsc_code" required type="text" pattern="[a-zA-Z]+.*"
                                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                                    name="ifsc_code" id="ifsc_code" class="form-control " placeholder="Enter Ifsc Code" value="{{$row->payload['ifsc_code']}}">
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                                                <label for="singin-email">Branch <span>*</span></label>
                                                <input name="branch" required type="text" pattern="[a-zA-Z]+.*"
                                                    title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control"
                                                    placeholder="Enter Branch " value="{{$row->payload['branch']}}">
                                            </div>
                                        </div>
                                    </fieldset>
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

@endsection
