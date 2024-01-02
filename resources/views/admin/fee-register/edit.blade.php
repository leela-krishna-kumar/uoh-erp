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
                                <!-- Form Start -->
                            <fieldset class="row scheduler-border">
                            <div class="col-md-6">
                                <div class="form-group col-md-12 ">
                                <label for="bank_id" class="form-label">{{ __('Deposited Bank') }} </label>
                                <select   class="form-control select2"  name="bank_id" id="bank_id">
                                    <option value=""> Select Name</option>
                                    @foreach($collegebank as $college)
                                        <option value="{{ $college->id }}" @if($college->id == $row->bank_id) selected @endif>{{ $college->bank->name}} | {{ $college->account_holder_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_college_banks') }}
                                </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="date">{{ __('Date') }} <span>*</span></label>
                                    <input type="date" class="form-control" name="date" id="date" value="{{$row->date}}" disabled required>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('date') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="status">{{ __('field_status') }}</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            @foreach ($statuses as $key => $status)
                                            <option value="{{$key}}" @if($key == $row->status) selected @endif>{{ $status['label'] }}</option>
                                            @endforeach
                                        </select>
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('Note') }} </label>
                                    <textarea type="text" class="form-control" name="note" id="note" value="" rows="8">{{$row->note}}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('note') }}
                                    </div>
                                </div>
                            </div>
                            </fieldset>
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
