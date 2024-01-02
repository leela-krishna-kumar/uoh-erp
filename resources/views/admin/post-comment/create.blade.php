
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
            <div class="col-sm-6 mx-auto">
                <div class="card">
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}?post_id={{@$post->id}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                  <div class="card">
                        <div class="card-header">
                        <h5>{{ __('btn_create') }} {{@$post->content}} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                              <input type="hidden" name="post_id" value="{{$post->id}}">
                        <!-- Form Start -->
                        <div class="form-group">
                              <label for="role_id" class="form-label">{{ __('field_role') }} <span>*</span></label>
                              <select class="form-control select2" name="role_id" id="role_id" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach($roles as $key => $role)
                                    @if($key === $roles->keys()->last())
                                          <option value="0">{{ __('field_student') }}</option>
                                    @endif
                                    <option value="{{ $role->id }}" @if(old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                              </select>
            
                              <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_role') }}
                              </div>
                        </div>
            
                        <div class="form-group">
                              <label for="comment">{{ __('Comment') }}</label>
                              <textarea type="text" class="form-control" name="comment" id="content" ></textarea>
            
                              <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Content') }}
                              </div>
                        </div>
                        <!-- Form End -->
                        </div>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
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

@section('page_js')
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>




<!-- Filter Search -->
@endsection