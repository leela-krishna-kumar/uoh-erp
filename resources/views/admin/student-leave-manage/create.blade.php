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
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.create') }}">
                            <div class="row gx-2">
                                @include('common.inc.student_search_filter')
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
            @if(isset($rows))
                @if(count($rows) > 0)
                    <div class="col-sm-12">
                        <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-block">
                                    <input type="text" name="faculty" value="{{ $selected_faculty }}" hidden>
                                    <input type="text" name="program" value="{{ $selected_program }}" hidden>
                                    <input type="text" name="session" value="{{ $selected_session }}" hidden>
                                    <input type="text" name="semester" value="{{ $selected_semester }}" hidden>
                                    <input type="text" name="section" value="{{ $selected_section }}" hidden>


                                    <!-- [ Data table ] start -->
                                    <div class="table-responsive">
                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">{{ __('Choose Student to apply leave') }} <span>*</span></label>
                                        <table class="display table nowrap table-striped table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('field_student_id') }}</th>
                                                    <th>{{ __('field_student') }}</th>
                                                    <th>{{ __('field_credit_hour_short') }}</th>
                                                    <th>{{ __('field_program') }}</th>
                                                    <th>{{ __('field_session') }}</th>
                                                    <th>{{ __('field_semester') }}</th>
                                                    <th>{{ __('field_section') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach( $rows as $key => $row )
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-primary d-inline">
                                                            <input type="checkbox"onclick="onlyOne(this)" name="student_id" id="checkbox-{{$row->id}}" value="{{$row->student_id}}" {{ $loop->first ? 'checked' : '' }}>
                                                            <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.student.show', $row->student->id) }}">
                                                        #{{ $row->student->student_id ?? '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $row->student->name ?? '' }}</td>
                                                    <td>
                                                        @php
                                                            $total_credits = 0;
                                                            foreach($row->subjects as $subject){
                                                                $total_credits = $total_credits + $subject->credit_hour;
                                                            }
                                                        @endphp
                                                        {{ $total_credits }}
                                                    </td>
                                                    <td>{{ $row->program->shortcode ?? '' }}</td>
                                                    <td>{{ $row->session->title ?? '' }}</td>
                                                    <td>{{ $row->semester->title ?? '' }}</td>
                                                    <td>{{ $row->section->title ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- [ Data table ] end -->
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <!-- Form Start -->
                                        <div class="form-group col-md-4">
                                            <label for="apply_date">{{ __('field_apply_date') }} <span>*</span></label>
                                            <input type="date" class="form-control" name="apply_date" id="apply_date" value="{{ date('Y-m-d') }}" readonly required>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_apply_date') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="from_date">{{ __('field_start_date') }} <span>*</span></label>
                                            <input type="date" class="form-control date" name="from_date" id="from_date" value="{{ old('from_date') }}" required>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_start_date') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="to_date">{{ __('field_end_date') }} <span>*</span></label>
                                            <input type="date" class="form-control date" name="to_date" id="to_date" value="{{ old('to_date') }}" required>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_end_date') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="subject">{{ __('field_leave_subject') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject') }}" required>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_leave_subject') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="status" class="form-label">{{ __('Type') }}</label>
                                            <select class="form-control" name="type" id="type">
                                                @foreach(App\Models\StudentLeave::TYPES as $key => $type)
                                                <option value="{{$key}}" >{{ $type['label'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="reason">{{ __('field_reason') }}</label>
                                            <textarea class="form-control" name="reason" id="reason">{{ old('reason') }}</textarea>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_reason') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="attach">{{ __('field_attach') }}</label>
                                            <input type="file" class="form-control" name="attach" id="attach" value="{{ old('attach') }}">

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_attach') }}
                                            </div>
                                        </div>
                                        <!-- Form End -->
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success "><i class="fas fa-check"></i> {{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="text-center">
                                <h6>No Student Found..</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
@section('page_js')

@yield('sub-script')
<script>

  function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('student_id')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    });
}

</script>
@endsection