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
                        <input type="hidden" name="user_id" value="{{auth()->id()}}">
                        <div class="wizard-sec-bg">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                  <fieldset class="row scheduler-border">
                                    <div class="form-group col-md-6">
                                        <label for="account_holder_name">{{ __('Account Holder Name') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" value="{{$row->account_holder_name}}"required>
  
                                        <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('account_holder_name') }}
                                        </div>
                                    </div>
  
                                    <div class="form-group col-md-6 ">
                                      <label for="bank_id" class="form-label">{{ __('field_college_banks') }} <span>*</span></label>
                                      <select   class="form-control select2"  name="bank_id" id="bank_id">
                                          <option value=""> Select Bank Name</option>
                                          @foreach($banks as $bank)
                                              <option value="{{ $bank->id }}" @if($bank->id  == $row->bank_id) selected @endif">{{ $bank->name }}</option>
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
                                                  required=""@if($row->type == 0) checked @endif>
                                              <label class="form-check-label pl-2 mb-1 " for="current">Current</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-check mb-2">
                                              <input name="type" value="1" type="radio" class="form-check-input pb-1"
                                              required="" @if($row->type == 1) checked @endif>
                                          <label class="form-check-label pl-2 mb-1 " for="saving">Saving</label>
                                          </div>
                                      </div>  
                                  </div>   
                                    <div class="form-group col-md-6" style="margin-left: 24px;"> 
                                        <label for="account_no">{{ __('Account Number') }} <span>*</span></label>
                                        <input type="number" class="form-control" name="account_no" id="account_no" min="0" value="{{$row->account_no}}" required>
                                        <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('account_no') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label for="ifsc">{{ __('IFSC') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="ifsc" id="ifsc" value="{{$row->ifsc}}" required>
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('ifsc') }}
                                      </div>
                                  </div>
  
                                    <div class="form-group col-md-6">
                                      <label for="branch">{{ __('Branch') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="branch" id="branch" value="{{$row->branch}}" required>
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('branch') }}
                                      </div>
                                  </div>
  
                                  <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                                </div>
                                  </fieldset>
                                </div>
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
<!-- End Content-->

@endsection
