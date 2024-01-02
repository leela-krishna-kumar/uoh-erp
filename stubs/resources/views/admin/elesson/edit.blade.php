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
                        {{-- @can($access.'-edit') --}}
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                        {{-- @endcan  --}}
                    </div>
                    <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                        <div class="wizard-sec-bg">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="{{$row->type}}" name="type">
                            <fieldset class="row scheduler-border">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="title">{{ __('Title') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}"required>
                                    </div> 
                                     <div class="form-group col-md-12">
                                        <label for="lession">{{ __('Section') }} <span>*</span></label>
                                        <select class="form-control select2" name="e_section_id" id="e_section_id" required>
                                            <option readonly value="">{{ __('Select Section') }}</option>
                                            @foreach($esections as $section)
                                            <option value="{{ $section->id }}"@if($row->e_section_id == $section->id) selected @endif>{{ $section->title }} </option>
                                            @endforeach
                                    </select>
                                    </div>  
                                    <div class="form-group col-md-12">
                                        <label for="link">{{ __('Link') }}<span>*</span></label>
                                        <input type="Url" class="form-control" name="link" id="link" value="{{$row->link}}" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('link') }}
                                        </div>
                                    <div class="form-group col-md-12">
                                        <div class="switch d-inline m-r-10">
                                            <label>{{ __('Is published') }}</label>
                                            <input type="checkbox" id="is_published" name="is_published" value="1" @if($row->is_published) checked @endif>
                                            <label for="is_published" class="cr"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="short_description">{{ __('Description') }}<span>*</span></label>
                                        <textarea type="text" name="short_description" id="short_description" class="form-control" rows="9" required>{{$row->short_description}}</textarea>
                                    </div>
                                </div>
                            </fieldset>
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
