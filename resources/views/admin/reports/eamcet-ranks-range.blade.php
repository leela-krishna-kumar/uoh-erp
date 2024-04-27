@extends('admin.layouts.master')
@section('title','')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        
        <div class="container">
            <!-- [ Data table ] start -->
            <h5>Eamcet Rank Range</h5>
            <div class="table-responsive">
                <table id="export-table2" class="display table nowrap table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>RANK RANGE</th>
                            <th>Total Students</th>

                            {{-- @foreach ($courses as $course)
                                <th>{{ $course }}</th>
                            @endforeach --}}
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($eamcet as $e)

                      @php
                        //  dd($e);

                        $range[] = $e['range'];
                        $student_count[] = $e['student_count'];
                      @endphp  

                        <tr>
                            <td>{{  $e['range'] }}</td>                                  
                            <td>{{ $e['student_count'] }}</td>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
            <!-- [ Data table ] end -->

            <div class="row" style="padding:10px;">
            <div class="col-md-12"> 
            <center>
                <div id="attendence1_barchart_material" style="height:300px;"></div>
            </center>
            </div>
            </div>

        </div>
    </div>
</div>
<!-- End Content-->


@php
    $intake = 0
@endphp
@endsection

@section('page_js')  
    <script>

google.charts.load('current', { 'packages': ['bar'] });
google.charts.setOnLoadCallback(att1DrawChart);
function att1DrawChart() {
    var range_0 = '<?php echo $range[0]; ?>';
    var student_count_0 = '<?php echo $student_count[0]; ?>';
    var range_1 = '<?php echo $range[1]; ?>';
    var student_count_1 = '<?php echo $student_count[1]; ?>';
    var range_2 = '<?php echo $range[2]; ?>';
    var student_count_2 = '<?php echo $student_count[2]; ?>';
    var range_3 = '<?php echo $range[3]; ?>';
    var student_count_3 = '<?php echo $student_count[3]; ?>';

    // console.log(intake);
    // var intake = <?php echo $intake; ?>;
    var data = google.visualization.arrayToDataTable([
        ['Hostel', 'Occupancy'],
        [range_0, parseInt(student_count_0)],
        [range_1, parseInt(student_count_1)],
        [range_2, parseInt(student_count_2)],
        [range_3, parseInt(student_count_3)],

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
