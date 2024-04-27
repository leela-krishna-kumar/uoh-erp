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
                                                   
                                                    <td data-bs-toggle="modal" data-bs-target="#classDetailsModal{{ $row->id }}" style="cursor: pointer;">
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
                                                                {{-- {{ $row->subject->title ?? '' }} / {{ $dayRows[$e]['subject']['title'] }} <br> --}}
                                                                <?php
                                                                $words2 = explode(' ', $row->subject->title);
                                                                $acronym2 = '';
                                                                foreach ($words2 as $word2) {
                                                                    $acronym2 .= strtoupper(substr($word2, 0, 1));
                                                                }
                                                            ?>
                                                                {{ $acronym2 }}<br>

                                                                {{-- @php echo $s .','. $e . ',' . $dayRows[$s]['start_time'] . ',' . $dayRows[$e]['start_time'] @endphp --}}
                                                                {{ $row->subject->code ?? '' }} / {{ $dayRows[$e]['subject']['code'] }}<br>

                                                                @php
                                                                    $duplicate = 1;
                                                                @endphp

                                                             @else

                                                             <?php
                                                                $words2 = explode(' ', $row->subject->title);
                                                                $acronym2 = '';
                                                                foreach ($words2 as $word2) {
                                                                    $acronym2 .= strtoupper(substr($word2, 0, 1));
                                                                }
                                                            ?>
                                                                {{ $acronym2 }}<br>
                                                                {{-- {{ $row->subject->title ?? '' }}<br> --}}
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
                @else
                    @include('student.layouts.no-data')
                @endif
            </div>
           
            <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="modal" id="classDetailsModal{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="classDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="classDetailsModalLabel">{{ $row->subject->code ?? '' }}</h6>
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
        </div>
    </div>
</div>

</body>
</html>


        </div>
        @include('student.layouts.footer.student-footer')
    </div>
    <!-- Main Contents -->
@endsection
<!-- End Content-->
@endsection