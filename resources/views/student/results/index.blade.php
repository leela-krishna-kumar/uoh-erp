@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')

<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
            <div class="items-center justify-between pb-5 sm:flex">
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold text-black"> {{ $title }}</h1>
                </div>
                <form class="needs-validation" method="get" action="{{ route($student_route) }}">
                    <div class="flex items-center space-x-3">
                        <div class="row gx-2">
                            <div class="form-group">
                                <label for="type">{{ __('field_exam') }} {{ __('field_type') }} <span>*</span></label>
                                <select class="form-control" name="type" id="type" required>
                                      <option value="">{{ __('select') }}</option>
                                      @foreach( $types as $type )
                                      <option value="{{ $type->id }}" @if( $selected_type == $type->id) selected @endif>{{ $type->title }}</option>
                                      @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                        </div>
                        {{-- <div class="bg-white border flex items-center overflow-hidden relative rounded-lg">
                            <i class="pl-4 -mr-2 relative uil-search"></i>
                            <input class="flex-1 max-h-9" placeholder="Search" type="text">
                        </div> --}}
                    </div>

                </form>

            </div>
            @if(isset($rows))
                <div class="card-block" style="margin-top: -20px;">
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    {{-- <th>{{ __('field_student') }}</th> --}}
                                    <th>{{ __('field_subject') }}</th>
                                    <th>{{ __('field_exam') }}</th>
                                    <th>{{ __('field_marks_obtained') }}</th>
                                    {{-- <th>{{ __('field_date') }}</th>
                                    <th>{{ __('field_start_time') }}</th>
                                    <th>{{ __('field_end_time') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($rows as $row)

                            @php

                                // $schema =  App\Models\QuestionPaperSchema::find($booklet->schema_id);
                                $subject =  App\Models\Subject::find($row->subject_id);
                                $exam = App\Models\ExamType::find($row->exam_type_id);
                                //$no_of_students=App\Models\BookletDetail::find($booklet->student_enroll_count);
                            @endphp

                                <tr>

                                    <td>{{  $row->student_enroll_id }} </td>
                                    <td>{{  $subject->title}} </td>
                                    <td>{{  $exam->title }} </td>
                                    <td>{{  $row->achieve_marks }} </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->
                </div>
            @else
                @include('student.layouts.no-data')
            @endif

        </div>
        @include('student.layouts.footer.student-footer')


    </div>
    <!-- Main Contents -->
@endsection
<!-- End Content-->

@endsection




