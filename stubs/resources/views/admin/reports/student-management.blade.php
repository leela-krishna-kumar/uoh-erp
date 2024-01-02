@extends('admin.layouts.master')
@section('title','')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ 'Student Management' }} {{ __('list') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2"><p class="mt-1 mb-0 text-dark">Student Intake</p></div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">920</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2"><p class="mt-1 mb-0 text-dark">Students Attendance</p></div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">2800/3600</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2"><p class="mt-1 mb-0 text-dark">Student Details</p></div>
                    <div class="ms-2">
                        <span class="mb-1 fs-5 fw-700 text-dark">3600</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2"><p class="mt-1 mb-0 text-dark">Employees & Staff</p></div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">1200</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2"><p class="mt-1 mb-0 text-dark">Fee Collection & O/S</p></div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">2.5Lca/10Lca</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="rounded border border-2 bg-light shadow-sm">
                    <div class="ms-2"><p class="mt-1 mb-0 text-dark">Hostel Occupancy</p></div>
                    <div class="ms-2">
                       <span class="mb-1 fs-5 fw-700 text-dark">1500/1800</span>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                  <canvas id="intakeChart" style="width:100%;max-width:800px"></canvas>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                  <canvas id="attendanceChart" style="width:100%;max-width:800px"></canvas>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                  <canvas id="detailsChart" style="width:100%;max-width:800px"></canvas>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                <canvas id="employeesStaff" style="width:100%;max-width:800px"></canvas>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                  <canvas id="feecollectionChart" style="width:100%;max-width:800px"></canvas>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="border bg-white">
                  <canvas id="hostelChart" style="width:100%;max-width:800px"></canvas>
                </div>
            </div> 
        </div>    
    </div>
</div>
<script>
var xValues = ["Team1", "Team2", "Team3", "Team4"];
var yValues = [21.8, 32.7, 10.9, 34.5];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9"
];

new Chart("intakeChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Student Intake"
    }
  }
});
new Chart("attendanceChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Student Attendance"
    }
  }
});
new Chart("detailsChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Student Details"
    }
  }
});

new Chart("employeesStaff", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Employees & Staff"
    }
  }
});
new Chart("feecollectionChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Fee Collection & O/S"
    }
  }
});
new Chart("hostelChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Hostal Occupancy"
    }
  }
});
</script>
<!-- End Content-->

@endsection