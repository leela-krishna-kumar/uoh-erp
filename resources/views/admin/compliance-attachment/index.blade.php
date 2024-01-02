@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<style>
    .note-bg{
        background-color: #f2fbfee6;
        padding: 8px 12px;   
    }
    .max-scroll-150{
        max-height: 150px;
        overflow: auto;
    }
</style>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <input type="hidden"name="compliance_id"value="{{$compliance->id}}">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Attachment</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="max-scroll-150 mb-3">
                                <p class="note-bg">{{ $compliance->title }} </p>
                                    <br>
                                <p class="text-muted">{{$compliance->note}}</p> 
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_name') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('field_upload') }} <span>*</span></label>
                                <input type="file" class="form-control" name="file" id="file" value="{{ old('file') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_upload') }}
                                </div>
                            </div>
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
                    <div class="card-header">
                        <h5>{{ __('Attachment List') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>Created At</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{Str::limit($row->name,30) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($row->created_at)) }}</td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$row->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                            <a href="{{ asset('uploads/'.$path.'/'.$row->file) }}" target="_blank"class="btn btn-icon btn-success btn-sm"><i class="fas fa-eye"></i></a>
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