@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Full calendar css -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/fullcalendar/css/fullcalendar.min.css') }}">
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ $title }}</h5>
                        <form action="" method="get" class="d-flex">
                            <div class="form-group">
                                <select name="category_id" id="category_id" class="form-control select2 w-100">
                                    <option value="" readonly>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == request()->get('category_id')) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="margin-left: 20px;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-block">

                        <!-- [ Calendar ] start -->
                        <div id='calendar' class='calendar'></div>
                        <!-- [ Calendar ] end -->

                    </div>
                </div>
            </div>
            <!-- [Event List] start -->
            <div class="col-xl-4 col-md-4 col-sm-12">
                <div class="card statistial-visit">
                    <div class="card-header">
                        <h5>{{ __('upcoming') }} {{ trans_choice('module_event', 1) }}</h5>
                    </div>
                    <div class="card-block">
                        @foreach($latest_events as $key => $latest_event)
                        @if($key <= 9)
                        <p>
                        <mark style="color: {{ $latest_event->color }}">
                            <i class="fas fa-calendar-check"></i> {{ $latest_event->title }}
                        </mark>
                        <br>
                        <small>
                            @if(isset($setting->date_format))
                            {{ date($setting->date_format, strtotime($latest_event->start_date)) }}
                            @else
                            {{ date("Y-m-d", strtotime($latest_event->start_date)) }}
                            @endif

                            @if($latest_event->start_date != $latest_event->end_date)
                             <i class="fas fa-exchange-alt"></i> 
                            @if(isset($setting->date_format))
                            {{ date($setting->date_format, strtotime($latest_event->end_date)) }}
                            @else
                            {{ date("Y-m-d", strtotime($latest_event->end_date)) }}
                            @endif
                            @endif
                        </small>
                        </p>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- [Event List] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
<div id="eventDescriptionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Select Participant To Start Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Form Start -->
                <div class="form-group">
                    <h6 class="form-label">{{ __('Date') }} </h6>
                    <div class="d-flex">
                        <p id="start_date"> </p> <i class="fas fa-exchange-alt mx-1"></i> <p id="end_date"></p>
                    </div>
                </div>
                <div class="form-group">
                    <h6 class="form-label">{{ __('Description') }} </h6>
                    <p id="description"></p>
                </div>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
    <!-- Full calendar js -->
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>


    <script type="text/javascript">
        // Full calendar
        $(window).on('load', function() {
            "use strict";
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                defaultDate: '@php echo date("Y-m-d"); @endphp',
                editable: false,
                droppable: false,
                events: [
                    @php
                        foreach($rows as $key => $row){
                            $endDateWithOneDay = date("Y-m-d", strtotime($row->end_date . ' +1 day'));
                            echo "{
                                    title: '".$row->title."',
                                    start: '".$row->start_date."',
                                    end: '".$endDateWithOneDay."',
                                    borderColor: '".$row->color."',
                                    backgroundColor: '".$row->color."',
                                    textColor: '#fff',
                                    id: '".$row->id."', // Add an ID to each event
                                    description: `".$row->description."`,
                                    start_date: '".date("Y-m-d", strtotime($row->start_date))."',
                                    end_date: '".date("Y-m-d", strtotime($row->end_date))."'
                                }, ";
                        }
                    @endphp
                    ],
                    eventClick: function(calEvent, jsEvent, view) {
                    $('#myModalLabel').text(calEvent.title);
                    $('#description').html(calEvent.description.replace(/\n/g, '<br>'));
                    $('#start_date').text(calEvent.start_date);
                    $('#end_date').text(calEvent.end_date);
                    $('#eventDescriptionModal').modal('show');
                }
            });
        });

    </script>
@endsection