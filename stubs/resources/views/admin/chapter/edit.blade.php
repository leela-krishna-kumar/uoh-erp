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
                        <div class="wizard-sec-bg">
                            @csrf
                            @method('PUT')

                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $row->name }}" required>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="name">Subject <span>*</span></label>
                                <select class="form-control" name="subject_id" id="subject_id"required>
                                  <option value="">{{ __('select') }}</option>
                                  @foreach ($subjects as $key => $subject)
                                      <option value="{{$subject->id}}" @if($row->subject_id == $subject->id) selected @endif>{{ $subject->title }}</option>
                                  @endforeach
                              </select>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} Subject
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="start_date">{{ __('field_start_date') }}  <span>*</span></label>
                                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $row->start_date }}" required>

                                <div class="invalid-feedback">
                                     {{ __('field_start_date') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="end_date">{{ __('field_end_date') }}  <span>*</span> </label>
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $row->end_date }}" required>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_end_date') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="note">{{ __('field_note') }}</label>
                                <textarea name="note" id="note" rows="6"class="form-control">{{$row->note}}</textarea>
                                <div class="invalid-feedback">{{ __('field_note') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="status">{{ __('field_status') }}</label>
                                <select class="form-control" name="status" id="status">
                                    {{-- <option value="">{{ __('select') }}</option> --}}
                                    @foreach ($statuses as $key => $status)
                                    <option value="{{$key}}" @if($key == $row->status) selected @endif>{{ $status['label'] }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_status') }}
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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
