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
                                    <label for="task">Task<span>*</span></label>
                                    <textarea required type="text" placeholder="Enter Task..." class="form-control" name="task" id="task" rows="7" >{{ $row->task }}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('task') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="status"> Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">{{ __('select') }}</option>
                                            @foreach ($statuses as $key => $status)
                                            <option value="{{$key}}" @if($key == $row->status) selected @endif>{{ $status['label'] }}</option>
                                            @endforeach
                                        </select>
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="completed_at">Completed At</label>
                                    <input type="datetime-local" class="form-control" name="completed_at" id="completed_at" value="{{ $row->completed_at }}" >
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_email') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="task">Deadline</label>
                                    <input type="datetime-local"class="form-control" name="deadline_at" id="deadline_at" value="{{ $row->deadline_at }}" >
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_task') }}
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