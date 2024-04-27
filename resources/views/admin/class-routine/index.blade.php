@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        td {
    /* max-width: 200px; Set a maximum width for the cell */
    overflow: hidden; /* Hide the overflow content */
    white-space: nowrap; /* Prevent line breaks within the content */
    text-overflow: ellipsis; /* Display an ellipsis (...) when the text overflows */
  }

  </style>
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
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="far fa-edit"></i> {{ __('modal_add') }} / {{ __('modal_edit') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        @can($access.'-print')
                        @if(isset($print) && isset($rows))

                        <button type="button" class="btn btn-dark" onclick="document.getElementById('print-routine').submit()">
                            <i class="fas fa-print"></i> {{ __('btn_print') }}
                        </button>

                        <form id="print-routine" target="_blank" method="post" action="{{ route($route.'.print') }}" hidden>
                            @csrf
                            <input type="hidden" name="program" value="{{ $selected_program }}">
                            <input type="hidden" name="session" value="{{ $selected_session }}">
                            <input type="hidden" name="semester" value="{{ $selected_semester }}">
                            <input type="hidden" name="section" value="{{ $selected_section }}">
                        </form>
                        @endif
                        @endcan
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route .'.index') }}">
                            <div class="row gx-2">
                                @include('common.inc.common_search_filter')
                                <div class="form-group col-md-2">
                                    <label for="class_type">{{ __('field_class_type') }}</label>
                                    <select class="form-control" name="class_type" id="class_type">
                                        @foreach (App\Models\Subject::CLASS_TYPES as $key => $class)
                                            <option value="{{ $key }}" @if( request('class_type') == $key ) selected @endif>{{ $class['label'] }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_class_type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    @if(isset($rows))
                    <div class="card-block">
                        <!-- [ Data table ] start -->

                        <div class="table-responsive">
                            <table class="table class-routine-table border p-10">
                                <tbody style="font-size: 12px">
                                    @php
                                        $weekdays = array('3', '4', '5', '6', '7', '1', '2');
                                        $days = array('day_saturday', 'day_sunday','day_monday', 'day_tuesday', 'day_wednesday', 'day_thursday', 'day_friday');
                                    @endphp
                            
                                    @foreach($weekdays as $weekday)
                                        @php
                                            $dayRows = $rows->where('day', $weekday);

                                           // $dayRows_1 = $dayRows->fetch_assoc();
                                        @endphp
                            
                                        @if($dayRows->count() > 0)
                                            <tr>
                                                <th style="font-weight: bold; text-align: left;">{{ __($days[$weekday - 1]) }}</th>

                                                @php
                                                    $i=0; $k=0; $duplicate = 0; 
                                                @endphp

                                                @php
                                                    // dd($dayRows->keys()->all());

                                                    $dayRows_indexes = $dayRows->keys()->all();

                                                   // dd(count($dayRows_indexes));

                                                  //  dd($dayRows_indexes[4]);
                                                @endphp

                                                @foreach($dayRows as $row)     
                                                
                                                @php
                                                  //  dd($dayRows); dd($row, )
                                                @endphp

                                                @php
                                                               
                                                               $k = $i+1 ;

                                                               if ($i <= count($dayRows_indexes)-2)
                                                               { 
                                                                    $s = $dayRows_indexes[$i++];
                                                                    $e = $dayRows_indexes[$i];

                                                                    $duplicate_probability = 1;
                                                                }else{
                                                                    $duplicate_probability = 0;
                                                                }        
                                                                
                                                               // dd($row, $i);
                                                                

                                                              //  print($dayRows[$s]['start_time'] . $dayRows[$e]['start_time']);
                                                            @endphp

                                                @if(isset($row->subject->title) && ($row->subject->title == 'Lunch Break'))
                                                <td>
                                                    <div class="class-time" style="color: yellow;">
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
                                                
                                                        {{ $start_time . ' - ' . $end_time }}<br>
                                                        {{ '' }}<br>
                                                        {{ $row->subject->title ?? '' }}<br>
                                                        {{ '' }}<br>
                                                        </div>
                                                </td>
                                                @else

                                                    @if ($duplicate != 1)                                                        
                                                    
                                                    <td data-toggle="modal" data-target="#classDetailsModal{{ $row->id }}" style="cursor: pointer;">
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

                                                             @if ($duplicate_probability == 1 && $dayRows[$s]['start_time'] == $dayRows[$e]['start_time'])
                                                                {{ $row->subject->title ?? '' }} / {{ $dayRows[$e]['subject']['title'] }} <br>

                                                                {{-- @php echo $s .','. $e . ',' . $dayRows[$s]['start_time'] . ',' . $dayRows[$e]['start_time'] @endphp --}}
                                                                {{ $row->subject->code ?? '' }} / {{ $dayRows[$e]['subject']['code'] }}<br>

                                                                @php
                                                                    $duplicate = 1;
                                                                @endphp

                                                             @else

                                                                {{ $row->subject->title ?? '' }}<br>
                                                                {{ $row->subject->code ?? '' }}<br>

                                                                {{-- @php echo $s .','. $e . ',' . $dayRows[$s]['start_time'] . ',' . $dayRows[$e]['start_time'] @endphp --}}


                                                                @php
                                                                    $duplicate = 0;
                                                                @endphp
                                                                
                                                            @endif 

                                                            

                                                            {{-- {{ $dayRows[$k]['start_time'] }} --}}

                                                            
                                                        </span>



                                                            </div>
                                                    </td>
                                                    @else
                                                        @php
                                                            $duplicate = 0;
                                                        @endphp
                                                    @endif
                                                    {{-- Modal --}}
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

                                                                    
                                                                    @if ($duplicate_probability == 1 && $dayRows[$s]['start_time'] == $dayRows[$e]['start_time'])

                                                                    <span style="font-weight: bold; font-size: 16px;">Subject Name - </span> {{ $row->subject->title }}<br>

                                                                    <span style="font-weight: bold; font-size: 16px;">Teacher Staff Id - </span> {{ $row->teacher->staff_id }}<br>
                                                                    <span style="font-weight: bold; font-size: 16px;">Teacher Name - </span> {{ $row->teacher->first_name . ' ' . $row->teacher->last_name ?? '' }}<br>

                                                                    <center><p style="padding: 10px;" >OR</p></center>

                                                                    <span style="font-weight: bold; font-size: 16px;">Subject Name - </span> {{ $dayRows[$e]['subject']['title'] }}<br>

                                                                    <span style="font-weight: bold; font-size: 16px;">Teacher Staff Id - </span> {{ $dayRows[$e]['teacher']['staff_id'] }}<br>
                                                                    <span style="font-weight: bold; font-size: 16px;">Teacher Name - </span> {{ $dayRows[$e]['teacher']['first_name'] . ' ' . $dayRows[$e]['teacher']['last_name'] }}<br>
                                                                
                                                                    <br />
                                                                    @php
                                                                        $duplicate = 1;
                                                                    @endphp

                                                             @else

                                                             <span style="font-weight: bold; font-size: 16px;">Subject Name - </span> {{ $row->subject->title }}<br>

                                                             <span style="font-weight: bold; font-size: 16px;">Teacher Staff Id - </span> {{ $row->teacher->staff_id }}<br>
                                                             <span style="font-weight: bold; font-size: 16px;">Teacher Name - </span> {{ $row->teacher->first_name . ' ' . $row->teacher->last_name ?? '' }}<br>

                                                                {{-- @php echo $s .','. $e . ',' . $dayRows[$s]['start_time'] . ',' . $dayRows[$e]['start_time'] @endphp --}}


                                                                @php
                                                                    $duplicate = 0;
                                                                @endphp
                                                                
                                                            @endif 

                                                                    <span style="font-weight: bold; font-size: 16px;">{{ __('field_group') }} - </span> {{ @$row->subject->group ? @$row->subject->group->name : '-' }}<br>
                                                                    <span style="font-weight: bold; font-size: 16px;">{{ __('field_class_type') }} - </span> {{ @App\Models\Subject::CLASS_TYPES[$row->subject->class_type]['label'] }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    {{-- End Modal --}}
                                                @endforeach
                                            </tr>
                                        @else
                                            <tr>
                                                <th style="font-weight: bold; text-align: left;">{{ __($days[$weekday - 1]) }}</th>
                                                <td colspan="5">No classes</td> <!-- Adjust colspan based on the number of columns -->
                                            </tr>
                                        @endif

                                        @php
                                          //  $i++;
                                        @endphp


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