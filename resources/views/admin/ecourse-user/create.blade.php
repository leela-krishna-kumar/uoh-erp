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
                        <h5>{{ __('modal_add') }} {{ @$title }} for {{@$course->title}}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($previous_route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create',['course_id' =>$course->id]) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.create') }}">
                            <div class="row gx-2">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
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
                    <form class="needs-validation" novalidate action="{{route($route.'.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        @php
                        $semesters =  App\Models\Semester::where('status',1)->get();
                    @endphp
                    <div class="form-group col-md-3">
                        <label for="portal_semester">Select Semester To Assign Course<span>*</span></label>
                        <select class="form-control" name="portal_semester" id="portal_semester" required>
                            <option value="">{{ __('select') }}</option>
                            @foreach ($semesters as $semester)
                            <option value={{$semester->id}}>{{$semester->title}}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="card">
                            <div class="card-block">
                                <input type="text" name="faculty" value="{{ $selected_faculty }}" hidden>
                                <input type="text" name="program" value="{{ $selected_program }}" hidden>
                                <input type="text" name="session" value="{{ $selected_session }}" hidden>
                                <input type="text" name="semester" value="{{ $selected_semester }}" hidden>
                                <input type="text" name="section" value="{{ $selected_section }}" hidden>


                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="checkbox checkbox-success d-inline">
                                                        <input type="checkbox" id="checkbox" class="all_select">
                                                        <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                                    </div>
                                                </th>
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
                                        @foreach($rows as $key => $row)
                                            @php
                                               $ecourse_user = App\Models\ECourseUser::where('course_id', $course->id)
                                               ->where('student_id', $row->student_id)->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="checkbox checkbox-primary d-inline">
                                                        <input type="checkbox" name="student_id[]" @if($ecourse_user) checked @endif id="checkbox-{{$row->id}}" value="{{$row->student_id}}">
                                                        <label for="checkbox-{{$row->id}}" class="cr"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.student.show', $row->student->id) }}">
                                                    #{{ $row->student->student_id ?? '' }}
                                                    </a>
                                                </td>
                                                <td>{{$row->student->full_name}}</td>
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
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                                </div>
                                <!-- [ Data table ] end -->
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
<script type="text/javascript">
     $(".all_select").on('click',function(e){
        if($(this).is(":checked")){
            $("input[name='student_id[]']").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            $("input[name='student_id[]']").prop('checked', false);
        }
    });
</script>
@yield('sub-script')
@endsection
