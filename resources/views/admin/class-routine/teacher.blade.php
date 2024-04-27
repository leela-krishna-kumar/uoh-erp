@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<head>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

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
                    @can('teacher-routine-filter')
                        <div class="card-block">
                            <form class="needs-validation" novalidate method="get" action="{{ route($route.'.teacher') }}">
                                <div class="row gx-2">
                                    <div class="form-group col-md-3">
                                        <label for="teacher">{{ __('field_staff_id') }} <span>*</span></label>
                                        <select class="form-control select2" name="teacher" id="teacher" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($teachers as $teacher)
                                                @php
                                                    $isSelected = (isset($selected_staff) && $selected_staff == $teacher->id);
                                                @endphp
                                                <option value="{{ $teacher->id }}" @if($isSelected) selected @endif>
                                                    {{ $teacher->staff_id }} - {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_staff_id') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endcan


                    @if(isset($rows))
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table class-routine-table border p-10">
                                <tbody>
                                    @php
                                        $weekdays = array('3', '4', '5', '6', '7', '1', '2');
                                        $days = array('day_saturday', 'day_sunday','day_monday', 'day_tuesday', 'day_wednesday', 'day_thursday', 'day_friday');
                                    @endphp
                            
                                    @foreach($weekdays as $weekday)
                                        @php
                                            $dayRows = $rows->where('day', $weekday);
                                        @endphp
                            
                                        @if($dayRows->count() > 0)
                                            <tr>
                                                <th style="font-weight: bold; text-align: left;">{{ __($days[$weekday - 1]) }}</th>
                                                @foreach($dayRows as $row)
                                                <td data-toggle="modal" data-target="#classDetailsModal{{ $row->id }}" style="cursor: pointer;" >
                                                    <div class="class-time">
                                                        @if(isset($setting->time_format))
                                                            <?php $start_time = date($setting->time_format, strtotime($row->start_time)); ?>
                                                        @else
                                                            <?php $start_time = date("h:i A", strtotime($row->start_time)); ?>
                                                        @endif
                                                
                                                        @if(isset($setting->time_format))
                                                            <?php $end_time = date($setting->time_format, strtotime($row->end_time)); ?>
                                                        @else
                                                            <?php $end_time = date("h:i A", strtotime($row->end_time)); ?>
                                                        @endif
                                                
                                                    <span style="word-wrap:break-word">    {{ $start_time . ' - ' . $end_time }}<br>
                                                        {{ __('field_room') }}: {{ $row->room->title ?? '' }}<br>
                                                        {{ $row->subject->title ?? '' }}<br>
                                                        {{ $row->subject->code ?? '' }}<br>
                                                    </span>
                                                        </div>
                                                </td>
                                                <div class="modal fade" id="classDetailsModal{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="classDetailsModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="classDetailsModalLabel">{{ $row->subject->code ?? '' }}</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                $program = App\Models\Program::where('id', $row->program_id)->first();
                                                                $session = App\Models\Session::where('id', $row->session_id)->first();
                                                                $semester = App\Models\Semester::where('id', $row->semester_id)->first();
                                                                $section = App\Models\Section::where('id', $row->section_id)->first();
                                                                ?>
                                                                <span style="font-weight: bold; font-size: 16px;">Program - </span> {{ $program->title }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">Session - </span> {{ $session->title }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">Semester - </span> {{ $semester->title }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">Section - </span> {{ $section->title }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">Subject Name - </span> {{ $row->subject->title }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">Teacher Staff Id - </span> {{ $row->teacher->staff_id }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">Teacher Name - </span> {{ $row->teacher->first_name . ' ' . $row->teacher->last_name ?? '' }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">{{ __('field_group') }} - </span> {{ @$row->subject->group ? @$row->subject->group->name : '-' }}<br>
                                                                <span style="font-weight: bold; font-size: 16px;">{{ __('field_class_type') }} - </span> {{ @App\Models\Subject::CLASS_TYPES[$row->subject->class_type]['label'] }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </tr>
                                        @else
                                            <tr>
                                                <th style="font-weight: bold; text-align: left;">{{ __($days[$weekday - 1]) }}</th>
                                                <td colspan="5">No classes</td> <!-- Adjust colspan based on the number of columns -->
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection