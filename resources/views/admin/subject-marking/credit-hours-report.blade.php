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
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.credit-hours-report') }}">
                            <div class="row gx-2">
                                @include('common.inc.student_search_filter')
                                <!-- <div class="form-group col-md-3">
                                    <label for="student">{{ __('field_student_id') }}</label>
                                    <select class="form-control select2" name="student" id="student">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}" @if($selected_student == $student->id) selected @endif>{{ $student->id }} - {{ $student->first_name }} {{ $student->last_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_student_id') }}
                                    </div>
                                </div> -->
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
                                        <th>#</th>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_subject') }} - {{ __('field_grade') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($rows)
                                  @foreach( $rows as $key => $row )
                                  @php
                                    $enroll = \App\Models\Student::enroll($row->id);
                                  @endphp
                                    @if($enroll->subjectMarks->count() > 0)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}">
                                            {{ $row->id }}
                                            </a>
                                        </td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>
                                            @foreach($enroll->subjectMarks as $mark)
                                            <span>
                                                {{ $mark->subject->code }} - 
                                                @foreach($grades as $grade)
                                                @if($grade->min_mark <= $mark->total_marks && $grade->max_mark >= $mark->total_marks)
                                                {{ $grade->title }}/{{ number_format((float)$grade->point, 2, '.', '') }}
                                                @endif
                                            </span> 
                                            @endforeach
                                            
                                            </br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                  @endforeach
                                  @endisset
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