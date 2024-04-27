@extends('admin.layouts.master')
@section('title','')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">

        <div class="container">

            <h5>Admission Vs Intake</h5>
            <!-- [ Data table ] start -->
            <div class="table-responsive">
                <table id="export-table1" class="display table nowrap table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Branch</th>
                            <th>Admission</th>
                            <th>Intake</th>
                            <th>Action</th>
                            {{-- @foreach ($courses as $course)
                                <th>{{ $course }}</th>
                            @endforeach --}}
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($active_students_branch_wise as $students_branch_wise)

                        @php

                        // dd($students_branch_wise);

                            $intake_data = App\Models\StudentIntake::where('faculty', $students_branch_wise->faculty_id)
                                        ->where('program', $students_branch_wise->program_id)
                                        ->where('batch', $students_branch_wise->batch_id)
                                        ->first();
                        @endphp

                        <tr>
                            <td>{{ $students_branch_wise->batch->title ?? '--' }}</td>
                            <td>{{ $students_branch_wise->program->shortcode ?? '--' }}</td>                                   
                            <td>{{ $students_branch_wise->count ?? '--' }}</td>
                            <td>{{ $intake_data->intake_count}} </td>     
                            <td><a target="_blank" type="button" href="{{ url('admin/admission/student?faculty=' . $students_branch_wise->faculty_id .'&program='. $students_branch_wise->program_id . '&session=' . $students_branch_wise->session_id . '&semester=' . $students_branch_wise->semester_id . '&section=all&status=all') }}" class="btn btn-success btn-sm">View</a> </td>                                                              
                        </tr>
                        @endforeach 



                    </tbody>
                </table>
            </div>

            @php

            $intake = '10';
              //  dd($intake_data->intake_count);
            @endphp

            <!-- [ Data table ] end -->

            {{-- <div class="row" style="padding:10px;">
            <div class="col-md-12"> --}}

            <div class="card-block">
                <center>
                <div id="attendence1_barchart_material" style="height:300px;"></div>
            </center>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')  

    <!-- chart Js -->
    {{-- <script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script> --}}
     {{-- <script src="{{ asset('public/js/reportjs_script.js') }}"></script> --}}

     <script>

google.charts.load('current', { 'packages': ['bar'] });


google.charts.setOnLoadCallback(att1DrawChart);

function att1DrawChart() {



    var intake = '<?php echo $intake; ?>';

    console.log(intake);
    // var intake = <?php echo $intake; ?>;


    var data = google.visualization.arrayToDataTable([
        ['Program', 'Intake', 'Admission'],
        ['CSE', parseInt(intake), 60],
        ['ECE', 115, 86],
        ['EEE', 66, 20],
        ['Mechanical', 100, 54]
    ]);

    var options = {
        chart: {
            // title: 'Student Attendence',
            subtitle: 'Daily (10/02/2023)',
        },
      //  colors: ['#ffb1c1', '#9ad0f5'],
      colors:['#36a2eb', '#ff6384'],
      backgroundColor : { fill:'transparent' },
        bars: 'vertical' // Required for Material Bar Charts.
        
    };

    var chart = new google.charts.Bar(document.getElementById('attendence1_barchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}


     </script>



@endsection
