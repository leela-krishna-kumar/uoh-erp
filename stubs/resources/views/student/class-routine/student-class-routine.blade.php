@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
            <div class="items-center justify-between  pb-5 sm:flex mb-0">
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold text-black"> Class Routine</h1> 
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-white border flex items-center overflow-hidden relative rounded-lg">
                        <i class="pl-4 -mr-2 relative uil-search"></i>
                        <input class="flex-1 max-h-9" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
            <div  id="course-tabs">
                @if(isset($rows))
                    <div class="card-block" style="margin-top: -20px;">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table class-routine-table border p-10">
                                <thead>
                                    <tr>
                                        <th>{{ __('day_saturday') }}</th>
                                        <th>{{ __('day_sunday') }}</th>
                                        <th>{{ __('day_monday') }}</th>
                                        <th>{{ __('day_tuesday') }}</th>
                                        <th>{{ __('day_wednesday') }}</th>
                                        <th>{{ __('day_thursday') }}</th>
                                        <th>{{ __('day_friday') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $weekdays = array('1', '2', '3', '4', '5', '6', '7');
                                    @endphp
                                    <tr>
                                        @foreach($weekdays as $weekday)
                                        <td>
                                            @foreach($rows->where('day', $weekday) as $row)
                                            <div class="class-time">
                                            {{ $row->subject->code ?? '' }}<br>
                                            @if(isset($setting->time_format))
                                            {{ date($setting->time_format, strtotime($row->start_time)) }}
                                            @else
                                            {{ date("h:i A", strtotime($row->start_time)) }}
                                            @endif <br/> @if(isset($setting->time_format))
                                            {{ date($setting->time_format, strtotime($row->end_time)) }}
                                            @else
                                            {{ date("h:i A", strtotime($row->end_time)) }}
                                            @endif<br>
                                            {{ __('field_room') }}: {{ $row->room->title ?? '' }}<br>
                                            {{ $row->teacher->first_name ?? '' }} {{ $row->teacher->last_name ?? '' }}
                                            </div>
                                            @endforeach
                                        </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                @else
                    @include('student.layouts.no-data')
                @endif
            </div>

        </div>
        @include('student.layouts.footer.student-footer')
    </div>
    <!-- Main Contents -->
@endsection
<!-- End Content-->
@endsection
    
        

