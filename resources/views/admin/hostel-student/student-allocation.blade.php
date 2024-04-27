@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5> Allocate Student To Hostel</h5>
                    </div>
                    <div class="card-block">
                        {{-- @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan --}}

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.create') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="hostel">Student Roll No <span>*</span></label>
                                    <input type="text" class="form-control" name = "search_roll" id="search_roll" required value="">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_hostel') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
@if(isset($row))
<div class="card">
    <div class="col-md-8 col-lg-8">
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ 'Student Details for :' }} {{$selected_search_roll}} </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Student Name:</strong> {{@$row->first_name}} {{@$row->last_name}}</td>
                                <td><strong>Program:</strong> {{@$row->program->title ?? ''}}</td>
                                {{-- <td>  </td> --}}
                            </tr>
                            <tr>
                                <td><strong>Batch:</strong> {{@$row->category->name ?? ''}}</td>
                                <td><strong>Phone:</strong> {{ $row->phone ?? '' }}</td>
                                {{-- <td></td> --}}
                            </tr>
                        </tbody>
                    </table>
                    {{-- <table class="table">
                        <tbody>
                            <tr>
                                <th>Student Name</th>
                                <td colspan="2">{{@$row->first_name}} {{@$row->last_name}}</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>{{@$row->program->title ?? ''}}</td>
                                <th>Batch</th>
                                <td>{{@$row->category->name ?? ''}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td colspan="3">{{ $row->phone ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table> --}}

                    <p>Select Hostel Details To Allocate :</p>
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <!-- Form Start -->
                            <input type="hidden" name="student_id" value="{{ $row->id }}">
                            <input type="hidden" name="member_id" value="{{ $row->hostelRoom->id ?? 1 }}">
                            {{-- <input type="hidden" name="member_id" value="{{ $row->hostelRoom->id ?? -1 }}"> --}}

                            @include('common.inc.hostel_room_filter')
                            <!-- Form End -->
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route($route.'.create') }}" class="btn btn-secondary"><i class="fas fa-times"></i> {{ __('btn_close') }}</a>
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button> -->
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </form>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
