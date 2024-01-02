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
                    <div class="col-sm-12">
                        <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <!-- Form Start -->
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label for="title">{{ __('Title') }} <span>*</span></label>
                                                        <input type="date" class="form-control" name="title" id="title" value="" required>
                        
                                                        <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('Title') }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="started_from">{{ __('Start Date') }} <span>*</span></label>
                                                        <input type="date" class="form-control" name="started_from" id="started_from" value="" required>
                        
                                                        <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('Start Date') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Form End -->
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
@endsection