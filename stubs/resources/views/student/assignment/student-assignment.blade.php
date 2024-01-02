@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print"> 
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
            <div class="items-center justify-between  pb-5 sm:flex">
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold text-black"> {{$title}}</h1> 
                </div>
                <div class="card-block">
                    <form class="needs-validation" method="get" action="{{ route($assignment_route) }}">
                        <div class="row gx-2">
                            <div class="form-group col-md-4">
                                <label for="session">{{ __('field_session') }}</label>
                                <select class="form-control bg-white" name="session" id="session">
                                    <option value="0">{{ __('all') }}</option>
                                    @foreach( $sessions as $session )
                                    <option value="{{ $session->session_id }}" @if( $selected_session == $session->session_id) selected @endif>{{ $session->session->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="semester">{{ __('field_semester') }}</label>
                                <select class="form-control bg-white" name="semester" id="semester">
                                    <option value="0">{{ __('all') }}</option>
                                    @foreach( $semesters as $semester )
                                    <option value="{{ $semester->semester_id }}" @if( $selected_semester == $semester->semester_id) selected @endif>{{ $semester->semester->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_semester') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-block" style="margin-top: -20px;">
                <!-- [ Data table ] start -->
                @if($rows->count() > 0)
                    <div class="table-responsive">
                        <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('field_title') }}</th>
                                    <th>{{ __('field_subject') }}</th>
                                    <th>{{ __('field_session') }}</th>
                                    <th>{{ __('field_semester') }}</th>
                                    <th>{{ __('field_start_date') }}</th>
                                    <th>{{ __('field_end_date') }}</th>
                                    <th>{{ __('field_status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $key => $row )
                            @if($row->assignment->status == 1)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    @php
                                    $unread = 0;
                                    $user = Auth::guard('student')->user();
                                    foreach ($user->unreadNotifications as $notification) {
                                        if($notification->data['type'] == 'assignment' && $notification->data['id'] == $row->assignment->id) {
                                            $unread = 1;
                                        }
                                    }
                                    @endphp
                                    <td>
                                        @if($unread == 1)
                                        <a href="{{ route($route.'.show', $row->id) }}"><b>{{ $row->assignment->title ?? '' }}</b></a>
                                        @else
                                        <a href="{{ route($route.'.show', $row->id) }}">{{ $row->assignment->title ?? '' }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $row->assignment->subject->code ?? '' }}</td>
                                    <td>{{ $row->studentEnroll->session->title ?? '' }}</td>
                                    <td>{{ $row->studentEnroll->semester->title ?? '' }}</td>
                                    <td>
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->assignment->start_date)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->assignment->start_date)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->assignment->end_date)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->assignment->end_date)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if( $row->attendance == 1 )
                                        <span class="badge badge-pill badge-success">{{ __('status_submitted') }}</span>
                                        @else
                                        <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @include('student.layouts.no-data')
                @endif
                <!-- [ Data table ] end -->
            </div>

        </div>

        @include('student.layouts.footer.student-footer')

    </div>
    <!-- Main Contents -->
@endsection
<!-- End Content-->

@endsection
        


