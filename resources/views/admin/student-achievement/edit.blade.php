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
                            <div class="form-group col-md-12">
                                <label for="type">{{ __('field_type') }}</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach ($types as $key => $type)
                                        <option value="{{$key}}" @if($key == $row->type) selected @endif>{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                <div class="invalid-feedback"> {{ __('field_type') }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="category_id">{{ __('field_category') }}</label>
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($achievement_categories as $category)
                                        <option value="{{ $category->id }}" @if($category->id == $row->category_id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_category') }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="date">{{ __('field_date') }}</label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ $row->date }}">
    
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_date') }}
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="note">{{ __('field_note') }}</label>
                                <textarea class="form-control" name="note" rows="9" id="note">{{ $row->note  }}</textarea>
    
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_note') }}
                                </div>
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