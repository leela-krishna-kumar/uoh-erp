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
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">

                                {{-- @if((auth()->user()->roles[0]->name == 'Super Admin') || (auth()->user()->roles[0]->name == 'admin')) --}}
                                    @include('common.inc.staff_search_filter')
                                {{-- @endif --}}

                                <div class="form-group col-md-2">
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
                                        <th>{{ __('field_staff_id') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_department') }}</th>
                                        <th>{{ __('field_designation') }}</th>
                                        <th>{{ __('field_role') }}</th>
                                        <th>{{ __('field_salary_type') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}">
                                                #{{ $row->staff_id }}
                                            </a>
                                        </td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>{{ $row->department->title ?? '' }}</td>
                                        <td>{{ $row->designation->title ?? '' }}</td>
                                        <td>@foreach($row->roles as $role) {{ $role->name ?? '' }} @endforeach</td>
                                        <td>
                                            @if( $row->salary_type == 1 )
                                            {{ __('salary_type_fixed') }}
                                            @elseif( $row->salary_type == 2 )
                                            {{ __('salary_type_hourly') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if( $row->is_admin != 1 )
                                            @can($access.'-edit')
                                            @if( $row->status == 1 )
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $row->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <!-- Include Confirm modal -->
                                            @include($view.'.confirm')

                                            @else

                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $row->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <!-- Include Confirm modal -->
                                            @include($view.'.confirm')
                                            @endif
                                            @endcan
                                            @endif

                                            {{-- @can($access.'-password-print')
                                            <a href="#" class="btn btn-dark btn-sm" onclick="PopupWin('{{ route($route.'.print-password', [$row->id]) }}', '{{ $title }}', 800, 500);"><i class="fas fa-print"></i> {{ __('field_password') }}</a>
                                            @endcan --}}

                                            <form action="{{ route($route.'.send-password', [$row->id]) }}" method="post" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-envelope"></i> {{ __('field_password') }}</button>
                                            </form>
                                            <br/>

                                            <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if( $row->is_admin != 1 || Auth::user()->is_admin == 1 )
                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @endif
                                            @can($access.'-card')
                                            <a href="#" class="btn btn-icon btn-warning btn-sm" onclick="PopupWin('{{ route($route.'.card', $row->id) }}', '{{ $title }}', 800, 500);">
                                                <i class="fas fa-address-card"></i>
                                            </a>
                                            @endif
                                            @if( $row->is_admin != 1 )
                                            @can($access.'-password-change')
                                            <button class="btn btn-icon btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal-{{ $row->id }}">
                                            <i class="fas fa-key"></i>
                                            </button>

                                            <!-- Include Password Change modal -->
                                            @include($view.'.password-change')
                                            @endcan
                                            @endif

                                            @if( $row->is_admin != 1 )
                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                            @endif
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
