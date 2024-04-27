@extends('admin.layouts.master')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@section('title', $title)
@section('page_css')

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

    {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/css/materialize.min.css'> --}}
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>

    

    <style>
        #pieChart {
            max-width: 100% !important;
            max-height: 500px !important;
        }

        .table-responsive {
            padding: 10px 0 10px 0;
        }


        div.material-table {
            padding: 0;
        }

        div.material-table .hiddensearch {
            padding: 0 14px 0 24px;
            border-bottom: solid 1px #DDDDDD;
            display: none;
        }

        div.material-table .hiddensearch input {
            margin: 0;
            border: transparent 0 !important;
            height: 48px;
            color: rgba(0, 0, 0, .84);
        }

        div.material-table .hiddensearch input:active {
            border: transparent 0 !important;
        }

        div.material-table table {
            table-layout: fixed;
        }

        div.material-table .table-header {
            height: 64px;
            padding-left: 24px;
            padding-right: 14px;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            display: flex;
            -webkit-display: flex;
            border-bottom: solid 1px #DDDDDD;
        }

        div.material-table .table-header .actions {
            display: -webkit-flex;
            margin-left: auto;
        }

        div.material-table .table-header .btn-flat {
            min-width: 36px;
            padding: 0 8px;
        }

        div.material-table .table-header input {
            margin: 0;
            height: auto;
        }

        div.material-table .table-header i {
            color: rgba(0, 0, 0, 0.54);
            font-size: 24px;
        }

        div.material-table .table-footer {
            height: 56px;
            padding-left: 24px;
            padding-right: 14px;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: row;
            flex-direction: row;
            -webkit-justify-content: flex-end;
            justify-content: flex-end;
            -webkit-align-items: center;
            align-items: center;
            font-size: 12px !important;
            color: rgba(0, 0, 0, 0.54);
        }

        div.material-table .table-footer .dataTables_length {
            display: -webkit-flex;
            display: flex;
        }

        div.material-table .table-footer label {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.54);
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: row
                /* works with row or column */

                flex-direction: row;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        div.material-table .table-footer .select-wrapper {
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: row
                /* works with row or column */

                flex-direction: row;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        div.material-table .table-footer .dataTables_info,
        div.material-table .table-footer .dataTables_length {
            margin-right: 32px;
        }

        div.material-table .table-footer .material-pagination {
            display: flex;
            -webkit-display: flex;
            margin: 0;
        }

        div.material-table .table-footer .material-pagination li:first-child {
            margin-right: 24px;
        }

        div.material-table .table-footer .material-pagination li a {
            color: rgba(0, 0, 0, 0.54);
        }

        div.material-table .table-footer .select-wrapper input.select-dropdown {
            margin: 0;
            border-bottom: none;
            height: auto;
            line-height: normal;
            font-size: 12px;
            width: 40px;
            text-align: right;
        }

        div.material-table .table-footer select {
            background-color: transparent;
            width: auto;
            padding: 0;
            border: 0;
            border-radius: 0;
            height: auto;
            margin-left: 20px;
        }

        div.material-table .table-title {
            font-size: 20px;
            color: #000;
        }

        div.material-table table tr td {
            padding: 0 0 0 56px;
            height: 48px;
            font-size: 13px;
            color: rgba(0, 0, 0, 0.87);
            border-bottom: solid 1px #DDDDDD;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        div.material-table table tr td a {
            color: inherit;
        }

        div.material-table table tr td a i {
            font-size: 18px;
            color: rgba(0, 0, 0, 0.54);
        }

        div.material-table table tr {
            font-size: 12px;
        }

        div.material-table table th {
            font-size: 12px;
            font-weight: 500;
            color: #757575;
            cursor: pointer;
            white-space: nowrap;
            padding: 0;
            height: 56px;
            padding-left: 56px;
            vertical-align: middle;
            outline: none !important;
        }

        div.material-table table th.sorting_asc,
        div.material-table table th.sorting_desc {
            color: rgba(0, 0, 0, 0.87);
        }

        div.material-table table th.sorting:after,
        div.material-table table th.sorting_asc:after,
        div.material-table table th.sorting_desc:after {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 16px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            word-wrap: normal;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            content: "arrow_back";
            -webkit-transform: rotate(90deg);
            display: none;
            vertical-align: middle;
        }

        div.material-table table th.sorting:hover:after,
        div.material-table table th.sorting_asc:after,
        div.material-table table th.sorting_desc:after {
            display: inline-block;
        }

        div.material-table table th.sorting_desc:after {
            content: "arrow_forward";
        }

        div.material-table table tbody tr:hover {
            background-color: #EEE;
        }

        div.material-table table th:first-child,
        div.material-table table td:first-child {
            padding: 0 0 0 24px;
        }

        div.material-table table th:last-child,
        div.material-table table td:last-child {
            padding: 0 14px 0 0;
        }

        div.dt-button-info {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 400px;
            margin-top: -100px;
            margin-left: -200px;
            text-align: center;
            z-index: 21;
            color: rgba(0, 0, 0, 0.6);
        }

        @media screen and (max-width: 640px) {
            div.dt-buttons {
                float: none !important;
                text-align: center;
            }
        }
    </style>

@endsection

@section('content')
    @php
        $from_date = now()->subDay(1)->format('Y-m-d');
        $to_date = now()->format('Y-m-d');
    @endphp
    <!-- Start Content-->
    <div class="main-body">
        <div class="page-wrapper">


            <!-- [ Main Content ] start -->


            @php
                $tabular_view = 'Branch-wise Details';
                $graph_view = 'graph view';
            @endphp


            @if (Auth::user()->hasRole('Teacher'))
            <div class="row">
                <!-- [ bitcoin-wallet section ] start-->
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card bg-c-blue bitcoin-wallet">
                        <div class="card-block">
                            <h5 class="text-white mb-2">Monthly Attendance</h5>
                            {{-- <h2 class="text-white mb-2 f-w-300">{{ getStudentAttendance($from_date,$to_date) }}</h2> --}}
                            <h2 class="text-white mb-2 f-w-300">128/138</h2>
                            <i class="fa-solid fa-scroll f-70 text-white"></i>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#attendence">View</button>
                            {{-- <a type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#siag">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card bg-c-blue bitcoin-wallet">
                        <div class="card-block">
                            <h5 class="text-white mb-2">Academic Achievements</h5>
                            {{-- <h2 class="text-white mb-2 f-w-300">{{ getStudentAttendance($from_date,$to_date) }}</h2> --}}
                            <h2 class="text-white mb-2 f-w-300">199</h2>
                            <i class="fa-solid fa-scroll f-70 text-white"></i>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#achievements">View</button>
                            {{-- <a type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#siag">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card bg-c-blue bitcoin-wallet">
                        <div class="card-block">
                            <h5 class="text-white mb-2">Lesson Plan</h5>
                            <h2 class="text-white mb-2 f-w-300">90%</h2>
                            <i class="fa-solid fa-scroll f-70 text-white"></i>
                            <a class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#lessonflow">View</a>
                            {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card  bg-c-blue bitcoin-wallet">
                        <div class="card-block">
                            <h5 class="text-white mb-2">Time Table</h5>
                            <h2 class="text-white mb-2 f-w-300">{{ $hostel_std_count }}</h2>
                            <i class="fa-solid fa-scroll f-70 text-white"></i>
                            <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#timetable">View</a>
                            {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <!-- [ bitcoin-wallet section ] end-->
            </div>

            @else

                <div class="row">
                    <!-- [ bitcoin-wallet section ] start-->
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="card bg-c-blue bitcoin-wallet">
                            <div class="card-block">
                                <h5 class="text-white mb-2">Admission Vs Intake</h5>
                                {{-- <h2 class="text-white mb-2 f-w-300">{{ getStudentAttendance($from_date,$to_date) }}</h2> --}}
                                <h2 class="text-white mb-2 f-w-300">{{ count($active_students) }}/{{ $intake_total }}</h2>
                                <i class="fa-solid fa-scroll f-70 text-white"></i>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#siat">{{ $tabular_view }}</button>
                                {{-- <a type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#siag">{{ $graph_view }}</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="card bg-c-blue bitcoin-wallet">
                            <div class="card-block">
                                <h5 class="text-white mb-2">Eamcet Ranks Range</h5>
                                {{-- <h2 class="text-white mb-2 f-w-300">{{ getStudentAttendance($from_date,$to_date) }}</h2> --}}
                                <h2 class="text-white mb-2 f-w-300">{{ $min_eamcet_rank }}-{{ $max_eamcet_rank }}</h2>
                                <i class="fa-solid fa-scroll f-70 text-white"></i>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#swerr">{{ $tabular_view }}</button>
                                {{-- <a type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#siag">{{ $graph_view }}</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="card bg-c-blue bitcoin-wallet">
                            <div class="card-block">
                                <h5 class="text-white mb-2">Seat Types</h5>
                                <h2 class="text-white mb-2 f-w-300">{{ count($seat_type_ids) }}</h2>
                                <i class="fa-solid fa-scroll f-70 text-white"></i>
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#swst">{{ $tabular_view }}</a>
                                {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="card  bg-c-blue bitcoin-wallet">
                            <div class="card-block">
                                <h5 class="text-white mb-2">Hostel Occupancy</h5>
                                <h2 class="text-white mb-2 f-w-300">{{ $hostel_std_count }}</h2>
                                <i class="fa-solid fa-scroll f-70 text-white"></i>
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#ssw">Hostel-wise
                                    details</a>
                                {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                            </div>
                        </div>
                    </div>
                    <!-- [ bitcoin-wallet section ] end-->
                </div>

            @endif


            <div class="row">
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card theme-bg bitcoin-wallet">
                        <div class="card-block">
                        <a href="{{ url('admin/exam/exam-result') }}" target="_blank">    
                            <h5 class="text-white mb-2">Latest Exam Pass %</h5>
                            <h2 class="text-white mb-2 f-w-300">92%</h2>
                            <i class="fa-solid fa-scroll f-70 text-white"></i>
                        </a>
                            {{-- <a class="btn btn-sm btn-success">{{ $tabular_view }}</a> --}}
                            {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card theme-bg bitcoin-wallet">
                        <div class="card-block">
                            <a href="{{ url('admin/hostel-attendance') }}" target="_blank">   
                                <h5 class="text-white mb-2">{{ __('Hostel Attendance') }}</h5>
                                <h2 class="text-white mb-2 f-w-300">97%</h2>
                                <i class="fa-solid fa-scroll f-70 text-white"></i>
                            </a>
                            {{-- <a class="btn btn-sm btn-success">{{ $tabular_view }}</a> --}}
                            {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card theme-bg bitcoin-wallet">
                        <div class="card-block">
                            <a href="{{ url('admin/placement') }}" target="_blank">   
                                <h5 class="text-white mb-2">{{ __('Placement Summary') }}</h5>
                                <h2 class="text-white mb-2 f-w-300">92%</h2>
                                <i class="fa-solid fa-scroll f-70 text-white"></i>
                            </a>
                            {{-- <a class="btn btn-sm btn-success">{{ $tabular_view }}</a> --}}
                            {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-3">
                    <div class="card theme-bg bitcoin-wallet">
                        <div class="card-block">
                            <a href="{{ url('admin/grievance') }}" target="_blank">  
                            <h5 class="text-white mb-2">{{ __('Complaints') }}</h5>
                            <h2 class="text-white mb-2 f-w-300">{{ $complaints_count  }}</h2>
                            <i class="fa-solid fa-scroll f-70 text-white"></i>
                        </a>
                            {{-- <a class="btn btn-sm btn-success">{{ $tabular_view }}</a> --}}
                            {{-- <a class="btn btn-sm btn-info">{{ $graph_view }}</a> --}}
                        </div>
                    </div>
                </div>
            </div>




            <div class="container">

                <div class="row" style="padding:10px;">

                    

                    <div class="col-md-6">
                        <!--Div that will hold the column chart-->
                        <h4>Student Attendance</h4>
                    </div>

                    <div class="col-md-6">
                        <!--Div that will hold the column chart-->
                        <h4>Staff Attendance</h4>
                    </div>

                </div>

                <div class="row" style="padding:10px;">


                    <div class="col-md-6">
                        <!--Div that will hold the column chart-->
                        <div id="attendence1_barchart_material" style="height:400px;"></div>
                    </div>

                    <div class="col-md-6">
                        <!--Div that will hold the column chart-->
                        <div id="attendence2_barchart_material" style="height:400px;"></div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6">
                        <h4>Fee Dues</h4>
                        <!--Div that will hold the pie chart-->
                        <div id="fee_dues_pie_chart"> </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Exam Results</h4>
                        <!--Div that will hold the pie chart-->
                        <div id="examresult_sbarchart_values"> </div>
                    </div>

                    <!-- <div class="col-md-3">
                        <div id="curve_chart"> </div>
                    </div> -->
                </div>

                <br /><br />

                <div class="row">

                    <div class="col-md-6">
                        <h4>Hostel Attendence</h4>
                        <div id="hostel_attendence_pie_chart" style="height:300px;"> </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Placements Summary</h4>
                        <div id="Placement_pie_chart" style="height:300px;"> </div>
                    </div>
                </div>

                <br /><br />

                <div class="row">

                    <div class="col-md-6">
                        <h4>Complaints</h4>
                        <!--Div that will hold the bar chart-->
                        <div id="curve2_chart" style="height:400px;"></div>
                    </div>

                    <div class="col-md-6">
                        <h4>Expenditure (in Lakhs)</h4>
                        <div id="barchart_values" style="height:300px;"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- End Content-->



    {{-- @include('admin.dashboard.modals') --}}
    @include('admin.dashboard.attendence')
    @include('admin.dashboard.achievements')
    @include('admin.dashboard.lessonflow')
    @include('admin.dashboard.timetable')
    @include('admin.dashboard.Admission_Vs_Intake_Modal')
    @include('admin.dashboard.Eamcet_Rank_Range_Modal')
    @include('admin.dashboard.Hostel_Occupancy_Modal')
    @include('admin.dashboard.Seat_Types_Modal')
    







@endsection



@section('page_js')


    <!-- chart Js -->
    {{-- <script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script> --}}
    <script src="{{ asset('/js/graph_scripts.js') }}"></script>

    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script> --}}





    {{-- <script>
        (function(window, document, undefined) {

            var factory = function($, DataTable) {

                "use strict";


                $('.search-toggle').click(function() {
                    if ($('.hiddensearch').css('display') == 'none')
                        $('.hiddensearch').slideDown();
                    else
                        $('.hiddensearch').slideUp();
                });

                /* Set the defaults for DataTables initialisation */
                $.extend(true, DataTable.defaults, {
                    dom: "<'hiddensearch'f'>" +
                        "tr" +
                        "<'table-footer'Blip'>",
                    renderer: 'material'
                });
                /* Default class modification */
                $.extend(DataTable.ext.classes, {
                    sWrapper: "dataTables_wrapper",
                    sFilterInput: "form-control input-sm",
                    sLengthSelect: "form-control input-sm"
                });

                /* Bootstrap paging button renderer */
                DataTable.ext.renderer.pageButton.material = function(settings, host, idx, buttons, page, pages) {
                    var api = new DataTable.Api(settings);
                    var classes = settings.oClasses;
                    var lang = settings.oLanguage.oPaginate;
                    var btnDisplay, btnClass, counter = 0;

                    var attach = function(container, buttons) {
                        var i, ien, node, button;
                        var clickHandler = function(e) {
                            e.preventDefault();
                            if (!$(e.currentTarget).hasClass('disabled')) {
                                api.page(e.data.action).draw(false);
                            }
                        };

                        for (i = 0, ien = buttons.length; i < ien; i++) {
                            button = buttons[i];

                            if ($.isArray(button)) {
                                attach(container, button);
                            } else {
                                btnDisplay = '';
                                btnClass = '';

                                switch (button) {

                                    case 'first':
                                        btnDisplay = lang.sFirst;
                                        btnClass = button + (page > 0 ?
                                            '' : ' disabled');
                                        break;

                                    case 'previous':
                                        btnDisplay = '<i class="material-icons">chevron_left</i>';
                                        btnClass = button + (page > 0 ?
                                            '' : ' disabled');
                                        break;

                                    case 'next':
                                        btnDisplay = '<i class="material-icons">chevron_right</i>';
                                        btnClass = button + (page < pages - 1 ?
                                            '' : ' disabled');
                                        break;

                                    case 'last':
                                        btnDisplay = lang.sLast;
                                        btnClass = button + (page < pages - 1 ?
                                            '' : ' disabled');
                                        break;

                                }

                                if (btnDisplay) {
                                    node = $('<li>', {
                                            'class': classes.sPageButton + ' ' + btnClass,
                                            'id': idx === 0 && typeof button === 'string' ?
                                                settings.sTableId + '_' + button : null
                                        })
                                        .append($('<a>', {
                                                'href': '#',
                                                'aria-controls': settings.sTableId,
                                                'data-dt-idx': counter,
                                                'tabindex': settings.iTabIndex
                                            })
                                            .html(btnDisplay)
                                        )
                                        .appendTo(container);

                                    settings.oApi._fnBindAction(
                                        node, {
                                            action: button
                                        }, clickHandler
                                    );

                                    counter++;
                                }
                            }
                        }
                    };

                    // IE9 throws an 'unknown error' if document.activeElement is used
                    // inside an iframe or frame.
                    var activeEl;

                    try {
                        // Because this approach is destroying and recreating the paging
                        // elements, focus is lost on the select button which is bad for
                        // accessibility. So we want to restore focus once the draw has
                        // completed
                        activeEl = $(document.activeElement).data('dt-idx');
                    } catch (e) {}

                    attach(
                        $(host).empty().html('<ul class="material-pagination"/>').children('ul'),
                        buttons
                    );

                    if (activeEl) {
                        $(host).find('[data-dt-idx=' + activeEl + ']').focus();
                    }
                };

                /*
                 * TableTools Bootstrap compatibility
                 * Required TableTools 2.1+
                 */
                if (DataTable.TableTools) {
                    // Set the classes that TableTools uses to something suitable for Bootstrap
                    $.extend(true, DataTable.TableTools.classes, {
                        "container": "DTTT btn-group",
                        "buttons": {
                            "normal": "btn btn-default",
                            "disabled": "disabled"
                        },
                        "collection": {
                            "container": "DTTT_dropdown dropdown-menu",
                            "buttons": {
                                "normal": "",
                                "disabled": "disabled"
                            }
                        },
                        "print": {
                            "info": "DTTT_print_info"
                        },
                        "select": {
                            "row": "active"
                        }
                    });

                    // Have the collection use a material compatible drop down
                    $.extend(true, DataTable.TableTools.DEFAULTS.oTags, {
                        "collection": {
                            "container": "ul",
                            "button": "li",
                            "liner": "a"
                        }
                    });
                }

            }; // /factory

            // Define as an AMD module if possible
            if (typeof define === 'function' && define.amd) {
                define(['jquery', 'datatables'], factory);
            } else if (typeof exports === 'object') {
                // Node/CommonJS
                factory(require('jquery'), require('datatables'));
            } else if (jQuery) {
                // Otherwise simply initialise as normal, stopping multiple evaluation
                factory(jQuery, jQuery.fn.dataTable);
            }

        })(window, document);



        $(document).ready(function() {
            $('#datatable').dataTable({
                "oLanguage": {
                    "sSearch": "",
                    "sSearchPlaceholder": "Pesquisar",
                    "sInfo": "_START_ -_END_ of _TOTAL_",
                    "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">All</option>' +
                        '</select></div>'
                },
                bAutoWidth: false,

                buttons: [{
                        text: '<span style="color:#4d4d4d; margin-right:15px">Print<span>',
                        extend: 'print',
                        className: '',
                        title: '',
                        //  autoPrint: false,
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend(
                                    '<h4>Title Test</h4>',
                                    //  Background table picture in print version is here
                                    '<img src="http://i.imgur.com/w931ov4.png" style="position: fixed;  top: 50%;  left: 50%;  transform: translate(-50%, -50%);" />'
                                );

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit', );
                        }
                    },
                    {
                        text: '<span style="color:#4d4d4d; margin-right:15px">Excel<span>',
                        extend: 'excelHtml5',
                    },
                    {
                        text: '<span style="color:#4d4d4d; margin-right:15px">Csv<span>',
                        extend: 'csvHtml5',
                    },
                    {

                        text: '<span style="color:#4d4d4d; margin-right:15px">Copy<span>',
                        extend: 'copyHtml5',

                    },
                ]
            });
        });
    </script> --}}


    <script type="text/javascript">
        "use strict";
        var labels = <?php echo $months; ?>;
        var fees = <?php echo $fees; ?>;
        var salaries = <?php echo $salaries; ?>;
        var incomes = <?php echo $incomes; ?>;
        var expenses = <?php echo $expenses; ?>;

        const data = {

            labels: labels,

            datasets: [{

                    label: '{{ trans_choice('module_student_fees', 2) }}',

                    backgroundColor: '#04a9f5',

                    borderColor: '#04a9f5',

                    data: fees,

                },
                {
                    label: '{{ __('field_salary') }} {{ __('status_paid') }}',

                    backgroundColor: '#f4c22b',

                    borderColor: '#f4c22b',

                    data: salaries,
                },
                {
                    label: '{{ trans_choice('module_income', 2) }}',

                    backgroundColor: '#1de9b6',

                    borderColor: '#1de9b6',

                    data: incomes,
                },
                {
                    label: '{{ trans_choice('module_expense', 2) }}',

                    backgroundColor: '#f44236',

                    borderColor: '#f44236',

                    data: expenses,
                }

            ]

        };
        const config = {

            type: 'line',

            data: data,

            options: {}

        };
        const lineChart = new Chart(

            document.getElementById('lineChart'),

            config

        );
    </script>


    <script type="text/javascript">
        "use strict";
        var student_fee = <?php echo $student_fee; ?>;
        var discounts = <?php echo $discounts; ?>;
        var fines = <?php echo $fines; ?>;
        var fee_paid = <?php echo $fee_paid; ?>;

        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['{{ __('field_student') }} {{ __('field_fee') }}', '{{ __('field_discount') }}',
                    '{{ __('field_fine_amount') }}', '{{ __('field_paid_amount') }}'
                ],
                datasets: [{
                    label: '# of Fees',
                    data: [
                        student_fee, discounts, fines, fee_paid
                    ],
                    backgroundColor: [
                        'rgba(29, 233, 182, 0.2)',
                        'rgba(244, 66, 54, 0.2)',
                        'rgba(244, 194, 43, 0.2)',
                        'rgba(4, 169, 245, 0.2)'
                    ],
                    borderColor: [
                        'rgba(29, 233, 182, 1)',
                        'rgba(244, 66, 54, 1)',
                        'rgba(244, 194, 43, 1)',
                        'rgba(4, 169, 245, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script type="text/javascript">
        "use strict";
        $(function() {
            var labels = <?php echo $months; ?>;
            var net_salary = <?php echo $net_salary; ?>;
            var total_allowance = <?php echo $total_allowance; ?>;
            var total_deduction = <?php echo $total_deduction; ?>;
            var total_tax = <?php echo $total_tax; ?>;
            //get the line chart canvas
            var ctx = $("#line-chartcanvas");

            //line chart data
            var data = {
                labels: labels,
                datasets: [{
                        label: "{{ __('field_salary') }} {{ __('status_paid') }}",
                        data: net_salary,
                        backgroundColor: "#04a9f5",
                        borderColor: "#038fcf",
                        fill: false,
                        lineTension: 0,
                        radius: 5
                    },
                    {
                        label: "{{ __('field_total_allowance') }}",
                        data: total_allowance,
                        backgroundColor: "#1de9b6",
                        borderColor: "#14cc9e",
                        fill: false,
                        lineTension: 0,
                        radius: 5
                    },
                    {
                        label: "{{ __('field_total_deduction') }}",
                        data: total_deduction,
                        backgroundColor: "#f44236",
                        borderColor: "#f22012",
                        fill: false,
                        lineTension: 0,
                        radius: 5
                    },
                    {
                        label: "{{ __('field_tax') }}",
                        data: total_tax,
                        backgroundColor: "#f4c22b",
                        borderColor: "#ecb50c",
                        fill: false,
                        lineTension: 0,
                        radius: 5
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                title: {
                    display: false,
                    position: "top",
                    text: "Line Graph",
                    fontSize: 16,
                    fontColor: "#888"
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        fontColor: "#888",
                        fontSize: 14
                    }
                }
            };

            //create Chart class object
            var chart = new Chart(ctx, {
                type: "line",
                data: data,
                options: options
            });
        });
    </script>
@endsection



@section('page_js')

@yield('sub-script')

@endsection