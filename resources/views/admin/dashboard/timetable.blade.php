{{-- Attendence Modal --}}
<div id="timetable" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Attendence Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="container">

                    @if(isset($rows))
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table class-routine-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('day_monday') }}</th>
                                        <th>{{ __('day_tuesday') }}</th>
                                        <th>{{ __('day_wednesday') }}</th>
                                        <th>{{ __('day_thursday') }}</th>
                                        <th>{{ __('day_friday') }}</th>
                                        <th>{{ __('day_saturday') }}</th>
                                        <th>{{ __('day_sunday') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $weekdays = array('3', '4', '5', '6', '7','1', '2');
                                    @endphp
                                    <tr>
                                        @foreach($weekdays as $weekday)
                                        <td>
                                            @foreach($rows->where('day', $weekday) as $row)
                                            <div class="class-time">
                                             {{ $row->subject->code ?? '' }} - 
                                                {{-- @if( $row->subject->class_type == 1 )
                                                    {{ __('class_type_theory') }}
                                                @elseif( $row->subject->class_type == 2 )
                                                    {{ __('class_type_practical') }}
                                                @elseif( $row->subject->class_type == 3 )
                                                    {{ __('class_type_both') }}
                                                @endif --}}
                                                <br>
                                            @if(isset($setting->time_format))
                                            {{ date($setting->time_format, strtotime($row->start_time)) }}
                                            @else
                                            {{ date("h:i A", strtotime($row->start_time)) }}
                                            @endif <br> @if(isset($setting->time_format))
                                            {{ date($setting->time_format, strtotime($row->end_time)) }}
                                            @else
                                            {{ date("h:i A", strtotime($row->end_time)) }}
                                            @endif<br>
                                            {{ __('field_room') }}: {{ $row->room->title ?? '' }}<br>
                                            {{-- {{ $row->teacher->staff_id }} - {{ $row->teacher->first_name ?? '' }} --}}
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
                    @endif

                </div>

                {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i>
                    {{ __('btn_close') }}</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                    {{ __('btn_save') }}</button>
            </div> --}}

            </div>

        </div>
    </div>
</div>