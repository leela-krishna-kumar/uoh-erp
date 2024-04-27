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
                                    <label for="status">{{ __('field_admission_type') }}</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="">{{__('Select')}}</option>
                                        <option value="all" @if( $selected_status == 'all')selected @endif>{{ __('all') }}</option>
                                        @foreach( $statuses as $status )
                                        <option value="{{ $status->id }}" @if( $selected_status == $status->id) selected @endif>{{ $status->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_admission_type') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="status">Seat Type</label>
                                    <select class="form-control" name="seat_type" id="seat_type">
                                        <option value="">{{__('Select')}}</option>
                                        <option value="all" @if( $selected_seat_type== 'all')selected @endif>{{ __('all') }}</option>
                                        @foreach( $seat_types->sortBy('id') as $seat_type)
                                        <option value="{{ $seat_type->id }}" @if( $selected_seat_type == $seat_type->id) selected @endif>{{ $seat_type->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_admission_type') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="status">Category</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">{{__('Select')}}</option>
                                        <option value="all" @if( $selected_user_category== 'all')selected @endif>{{ __('all') }}</option>
                                        @foreach( $user_categories->sortBy('id') as $user_category)
                                        <option value="{{ $user_category->id }}" @if( $selected_user_category == $user_category->id) selected @endif>{{ $user_category->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_admission_type') }}
                                    </div>
                                </div>

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
                                        <th>{{ __('field_roll_no') }}</th>
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
                                        <th>{{ __('field_status') }}</th>
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
                                        <td>{{ $row->roll_no }}</td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>
                                            {{ $row->program->shortcode ?? '--' }}
                                                <div class="hr-1"></div>
                                            {{ $row->session->title ?? '--' }}
                                        </td>
                                        <td>
                                            {{ $row->semester->title ?? '--' }}
                                                <div class="hr-1"></div>
                                            {{ $row->section->title ?? '--' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $row->statusType->title }}</span><br>
                                            <!-- @foreach($row->statuses as $key => $status)
                                            <span class="badge badge-primary">{{ $status->title }}</span><br>
                                            @endforeach -->
                                        </td>
                                        <td>{{ $row->updated_at ?? '' }}</td>
                                        {{-- <td>
                                            @can($access.'-edit')
                                            @if( $row->login == 1 )
                                            <a href="{{ route($route.'.status', $row->id) }}" class="btn btn-icon btn-danger btn-sm"><i class="fas fa-times"></i></a>
                                            @else
                                            <a href="{{ route($route.'.status', $row->id) }}" class="btn btn-icon btn-success btn-sm"><i class="fas fa-check"></i></a>
                                            @endif
                                            @else
                                            @if( $row->login == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_blocked') }}</span>
                                            @endif
                                            @endcan
                                        </td> --}}
                                        <td>
                                            @can($access.'-password-print')
                                            <a href="#" class="btn btn-dark btn-sm" onclick="PopupWin('{{ route($route.'.print-password', [$row->id]) }}', '{{ $title }}', 800, 500);"><i class="fas fa-print"></i> {{ __('field_password') }}</a>
                                            @endcan

                                            <form action="{{ route($route.'.send-password', [$row->id]) }}" method="post" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-envelope"></i> {{ __('field_password') }}</button>
                                            </form>
                                            <br/>

                                            <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan

                                            @can($access.'-card')
                                            @if(isset($print))
                                            <a href="#" class="btn btn-icon btn-warning btn-sm" onclick="PopupWin('{{ route($route.'.card', $row->id) }}', '{{ $title }}', 800, 500);">
                                                <i class="fas fa-address-card"></i>
                                            </a>
                                            @endif
                                            @endcan

                                            @can($access.'-password-change')
                                            <button class="btn btn-icon btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal-{{ $row->id }}">
                                            <i class="fas fa-key"></i>
                                            </button>

                                            <!-- Include Password Change modal -->
                                            @include($view.'.password-change')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
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
