@extends('student.layouts.student-master')
<!-- Start Content-->
@section('content')
<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">
    <!-- Main Contents -->
    <div class="main_content">

        <div class="container">

            <div class="items-center justify-between pb-5 sm:flex">
                <div class="flex-1">
                    <h3 class="text-2xl font-semibold text-black"> Calendar</h3>
                </div>
                <div class="flex items-center space-x-3">
                    
                    <div class="bg-white border flex items-center overflow-hidden relative rounded-lg">
                        <i class="pl-4 -mr-2 relative uil-search"></i>
                        <input class="flex-1 max-h-9" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ trans_choice('module_calendar', 2) }}</h5>
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


        </div>

        <!-- footer -->
        <div class="lg:mt-28 mt-10 mb-7 px-12 border-t pt-7">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <p class="capitalize font-medium"> © copyright 2023  </p>
                <div class="lg:flex space-x-4 text-gray-700 capitalize hidden">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
            </div>
        </div>

    </div>
    <div id="eventDescriptionModal" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title"></h2>
            </div>
            <div class="uk-modal-body" style=" height: 70vh;
            overflow: auto;">
                <div class="row">
                    <div class="form-group">
                        <h6 class="form-label">{{ __('Date') }} </h6>
                        <div class="d-flex">
                            <p id="start_date"> </p> <i class="fas fa-exchange-alt mx-1 my-1"></i> <p id="end_date"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <h6 class="form-label">{{ __('Description') }} </h6>
                        <p id="description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Main Contents -->
@endsection
<!-- End Content-->
@push('script')
<script src="{{ asset('dashboard/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>
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
                foreach($events as $key => $event){
                    // Use template literals for multiline description
                    echo "{
                            title: '".$event->title."',
                            start: '".$event->start_date."',
                            end: '" . date("Y-m-d", strtotime($event->end_date . " +1 day")) . "',
                            borderColor: '".$event->color."',
                            backgroundColor: '".$event->color."',
                            textColor: '#fff',
                            id: '".$event->id."', // Add an ID to each event
                            description: `".$event->description."`,
                            start_date: '".date("Y-m-d", strtotime($event->start_date))."',
                            end_date: '".date("Y-m-d", strtotime($event->end_date))."'
                        }, ";
                }
            @endphp

            ],
            eventClick: function(calEvent, jsEvent, view) {
                $('.uk-modal-title').text(calEvent.title);
                $('#description').html(calEvent.description.replace(/\n/g, '<br>'));
                $('#start_date').text(calEvent.start_date);
                $('#end_date').text(calEvent.end_date);
                UIkit.modal('#eventDescriptionModal').show();
            }
        });
    });

</script>
@endpush
    
