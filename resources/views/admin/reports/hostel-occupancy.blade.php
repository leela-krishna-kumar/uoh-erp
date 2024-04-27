@extends('admin.layouts.master')
@section('title','')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
       
    
    <div class="container">
        <h5>Hostel Occupancy</h5?>
        <!-- [ Data table ] start -->
        <div class="table-responsive">
            <table id="export-table4" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Hostel Name</th>
                        <th>Total Students</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    
                    @foreach ($hostel_data as $hostel)    
                    
                    @php
                        $hostel_d = App\Models\Hostel::find($hostel->hostel_id);

                        $hostel_name[] =  $hostel_d->name;
                        $hostel_count[] =  $hostel->count;
                    @endphp
    
                        <tr>
                            <td>{{ $hostel_d->name }}</td>
                            <td>{{ $hostel->count }}</td>
                            <td><a target="_blank" type="button" href="{{ url('admin/hostel-student?hostel=' . $hostel->hostel_id. '&faculty=&program=&session=&semester=&section=') }}" class="btn btn-success btn-sm">View</a> </td>                                                              
                                                                        
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- [ Data table ] end -->
    
        <div class="row" style="padding:10px;">
        <div class="col-md-12">
        <center>
            <div id="attendence1_barchart_material" style="height:auto;"></div>
        </center>
        </div>
        </div>
    
    </div>
    

    </div>
</div>
<!-- End Content-->

@endsection


@php
    $intake = 0
@endphp

@section('page_js')  
    <script>

google.charts.load('current', { 'packages': ['bar'] });
google.charts.setOnLoadCallback(att1DrawChart);
function att1DrawChart() {
    var hostel_name_0 = '<?php echo $hostel_name[0]; ?>';
    var hostel_count_0 = '<?php echo $hostel_count[0]; ?>';
    var hostel_name_1 = '<?php echo $hostel_name[1]; ?>';
    var hostel_count_1 = '<?php echo $hostel_count[1]; ?>';
    var hostel_name_2 = '<?php echo $hostel_name[2]; ?>';
    var hostel_count_2 = '<?php echo $hostel_count[2]; ?>';

    // console.log(intake);
    // var intake = <?php echo $intake; ?>;
    var data = google.visualization.arrayToDataTable([
        ['Hostel', 'Occupancy'],
        [hostel_name_0, parseInt(hostel_count_0)],
        [hostel_name_1, parseInt(hostel_count_1)],
        [hostel_name_2, parseInt(hostel_count_2)],
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

