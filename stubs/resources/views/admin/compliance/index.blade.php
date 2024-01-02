@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->

                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{ __('field_category') }} <span>*</span></label>
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="">{{ __('select') }}</option>
                                    @foreach($categories as $category )
                                        <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_category') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note" class="form-label">{{ __('field_note') }} <span>*</span></label>
                                <textarea name="note" id=""class="form-control" rows="5"required></textarea>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_note') }}
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
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div><h5>{{ $title }} {{ __('list') }}</h5></div>
                        <div class="">
                            <form class="needs-validation d-flex" novalidate method="get" action="{{ route($route.'.index') }}">
                                <div>
                                    <select class="form-control" name="category_id" id="category_id" required>
                                        <option value="">{{ __('Select Category') }}</option>
                                        @foreach($categories as $category )
                                            <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-info ms-2"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                    <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_category') }}</th>
                                        <th>{{ __('Attachments') }}</th>
                                        
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$row->title}}</td>
                                        <td>{{@$row->category->name}}</td>
                                        <td class="text-center"> 
                                            <a href="{{route('admin.compliance-attachment.show',[$row->id])}}" type="button" class="text-primary">{{$row->attachments->count()}} 
                                            </a>
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan

                                            <a title="Attachments" href="{{route('admin.compliance-attachment.show',[$row->id])}}" type="button" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-paperclip"></i>
                                            </a>

                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection