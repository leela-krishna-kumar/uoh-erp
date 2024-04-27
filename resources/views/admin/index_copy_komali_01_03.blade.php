@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<style>
    #pieChart {
        max-width: 100% !important;
        max-height: 500px !important;
    }

    .blue-border {
        border: 2px solid blue;
    }

    .blue-border .card-block {
        color: white;
    }

    .table-body-bg {
        background-color: #f5f5f5;
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
        <!-- Your existing content here -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ bitcoin-wallet section ] start-->
            <div class="col-sm-6 col-md-6 col-xl-6">
                <div class="card bg-c-yellow blue-border">
                    <div class="card-block">
                        <h5 class="text-black mb-2">1. Number of Students Intake Vs Admission</h5>
                        @php
                            $faculty = \App\Models\Faculty::where('title', 'Engineering')->first();
                            $programs = \App\Models\Program::where('faculty_id', $faculty->id)->select('id', 'title', 'shortcode')->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Program Name</th>
                                        <th>Intake Count</th>
                                        <th>Admission Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programs as $program)
                                        @php
                                            $students_intake = DB::table('students_intake')->where('program', $program->id)->first();
                                            $intake = 0;
                                            $admitted_count = 0;
                                            if($students_intake) {
                                                $intake = $students_intake->intake_count;
                                                $admitted_count = $students_intake->admitted_count;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $program->shortcode }}</td>
                                            <td>{{ $intake }}</td>
                                            <td>{{ $admitted_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <canvas id="barChart" width="400" height="200"></canvas>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var programNames = [];
    var intakeCounts = [];
    var admittedCounts = [];
    @foreach($programs as $program)
        programNames.push("{{ $program->shortcode }}");
        intakeCounts.push({{ $program->intake }});
        admittedCounts.push({{ $program->admitted_count }});
    @endforeach

    // Create bar chart
    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: programNames,
            datasets: [{
                label: 'Intake Count',
                data: intakeCounts,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Admitted Count',
                data: admittedCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
@endsection

