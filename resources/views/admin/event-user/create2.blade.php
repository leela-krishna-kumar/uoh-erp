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

                    <form class="needs-validation" novalidate action="{{ route($route.'.store',['event_id' =>$event_id]) }}" method="post" enctype="multipart/form-data">
                      <div class="wizard-sec-bg">
                          @csrf
                          {{-- <content class="form-step"> --}}
                            <!-- Form Start -->
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                   {{-- <div class="form-group col-md-6">
                                      <label for="Event">{{ __('Event Id') }} <span>*</span></label>
                                      <input type="number" class="form-control" name="event_id" id="event_id" value="{{ old('role_id') }}" required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('role') }}
                                      </div>
                                  </div> --}}
                                  {{-- <div class="form-group col-md-6">
                                      <label for="name">{{ __('Role') }} <span>*</span></label>
                                      <input type="number" class="form-control" name="role_id" id="role_id" value="{{ old('role_id') }}" required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('role') }}
                                      </div>
                                  </div> --}}
                                  {{-- <div class="form-group col-md-6">
                                      <label for="User Role">{{ __('User Role') }} <span>*</span></label>
                                      <input type="number" class="form-control" name="role_user_id" id="role_user_id" value="{{ old('role_user_id') }}" required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('role') }}
                                      </div>
                                  </div> --}}
                                                               
                                  <div class="form-group col-md-6">
                                      <label for="Title">{{ __('Title') }} <span>*</span></label>
                                      <input type="text" class="form-control" name="title" value="{{ old('title') }}"required>

                                      <div class="invalid-feedback">{{ __('field_title') }}
                                      </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="Note">{{ __('Note') }}</label>
                                      <textarea name="note" id="note" rows="6"class="form-control"></textarea>
                                      <div class="invalid-feedback">{{ __('Note') }}
                                      </div>
                                  </div>
                            
                                  <div class="form-group col-md-6">
                                      <label for="comment">{{ __('Comment') }}</label>
                                      <textarea name="comment" id="comment" rows="6"class="form-control"></textarea>
                                      <div class="invalid-feedback">{{ __('Comment') }}
                                      </div>
                                  </div>
                                </fieldset>
                              </div>
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