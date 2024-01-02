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
                            <h5>Counselling</h5>
                        </div>
                        <div class="card-block">
                            <a href="{{ route($route . '.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i>
                                {{ __('btn_back') }}</a>

                            <a href="{{ route($route . '.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i>
                                {{ __('btn_refresh') }}</a>
                        </div>
                        <div class="card-block">
                            <form class="needs-validation" novalidate method="get" action="{{ route('admin.assign-student.create') }}">
                                <div class="row gx-2">
                                    @include('common.inc.student_search_filter')
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i>
                                            {{ __('btn_filter') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- [ Card ] end -->
                @if (isset($rows))
                    @if (count($rows) > 0)
                        <div class="col-sm-12">
                            <form class="needs-validation" novalidate action="{{ route('admin.assign-student.store') }}"
                                method="post" enctype="multipart/form-data">
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
                                            <table class="display table nowrap table-striped table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            #
                                                        </th>
                                                        <th>{{ __('field_student_id') }}</th>
                                                        <th>{{ __('field_student') }}</th>
                                                        <th>{{ __('Counsellor') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rows as $key => $row)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox checkbox-primary d-inline">
                                                                    <input type="checkbox" name="student_id[]" id="checkbox-{{ $row->id }}"
                                                                        value="{{ $row->student_id }}"
                                                                        @if (in_array($row->student_id, (array) old('student_id', []))) checked @endif>
                                                                    <label for="checkbox-{{ $row->id }}"
                                                                        class="cr"></label>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <a
                                                                    href="{{ route('admin.student.show', $row->student->id) }}">
                                                                    #{{ $row->student->student_id ?? '' }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $row->student->name ?? '' }}</td>
                                                            <td>{{ @$row->student->teacher->first_name }} {{ @$row->student->teacher->last_name }}</td>
                                                          
                                                           
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- [ Data table ] end -->
                                    </div>
                                </div>
                                <div class="card mt-0">
                                    <div class="card-block">
                                        <div class="row">
                                            {{-- @dd( request()->get('session_id')); --}}
                                            <input type="hidden" name="session_id"
                                                value="{{ request()->get('session_id') }}">
                                            <!-- Form Start -->
                                            <div class="form-group col-md-6">
                                                <label for="counselled_by">{{ __('Counsellor') }} <span>*</span></label>
                                                <select class="form-control" name="counselled_by" id="counselled_by"
                                                    required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}"
                                                            @if (old('counselled_by') == $teacher->id) selected @endif>
                                                            {{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_teacher') }}
                                                </div>
                                            </div>
                                            <!-- Form End -->
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success "><i class="fas fa-check"></i>
                                            {{ __('Save') }}</button>
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
@endsection
