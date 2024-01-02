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
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="d-flex justify-content-between">
                            <div>
                                @can($access.'-create')
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                                @endcan

                                <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                            </div>
                            <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                                <div style="display: inline-flex;">
                                    <input type="text" id="id" name="id" class="form-control" required value="{{request()->id}}" style="margin-right: 5px;">
                                    <button type="submit" class="ml-2 btn btn-info"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                @include('common.inc.student_search_filter')
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>
                                            {{ __('field_program') }}
                                            <div class="hr-1"></div>
                                            {{ __('field_session') }}
                                        </th>
                                        <th>
                                            {{ __('field_semester') }}
                                            <div class="hr-1"></div>
                                            {{ __('field_section') }}
                                        </th>
                                        {{-- <th>{{ __('field_login') }}</th> --}}
                                        <th>{{ __('field_last_updated_at') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                  @php
                                    $enroll = \App\Models\Student::enroll($row->id);
                                  @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}">
                                            {{ $row->id }}
                                            </a>
                                        </td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>
                                            {{ $row->program->shortcode ?? '--' }}
                                                <div class="hr-1"></div>
                                            {{ $enroll->session->title ?? '--' }}
                                        </td>
                                        <td>
                                            {{ $enroll->semester->title ?? '--' }}
                                                <div class="hr-1"></div>
                                            {{ $enroll->section->title ?? '--' }}
                                        </td>
                                        <td>{{ $row->updated_at ?? '' }}</td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan
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
@section('page_js')

@yield('sub-script')

@endsection