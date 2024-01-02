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
                                    <th>{{ __('field_subject') }}</th>
                                    <th>{{ __('field_teacher') }}</th>
                                    <th>{{ __('field_room') }}</th>
                                    <th>{{ __('field_date') }}</th>
                                    <th>{{ __('field_start_time') }}</th>
                                    <th>{{ __('field_end_time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $key => $row)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->subject->code ?? '' }} - {{ $row->subject->title ?? '' }}</td>
                                    <td>
                                        @foreach($row->users as $teacher)
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}@if($loop->last) @else , @endif<br/>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($row->rooms as $room)
                                        {{ $room->title }}@if($loop->last) @else , @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->date)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->date)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($setting->time_format))
                                        {{ date($setting->time_format, strtotime($row->start_time)) }}
                                        @else
                                        {{ date("h:i A", strtotime($row->start_time)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($setting->time_format))
                                        {{ date($setting->time_format, strtotime($row->end_time)) }}
                                        @else
                                        {{ date("h:i A", strtotime($row->end_time)) }}
                                        @endif
                                    </td>
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
    

        

