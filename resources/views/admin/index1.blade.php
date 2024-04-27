@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<style>
    #pieChart{
        max-width: 100% !important;
        max-height: 500px !important;
    }
    .white-text-table td,
    .white-text-table th {
        color: white;
    }
</style>
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ bitcoin-wallet section ] start-->
            <div class="col-sm-6 col-md-6 col-xl-7">
                <div class="card bg-c-blue ">
                    <div class="card-block">
                        <h5 class="text-white mb-2">Students with Eamcet Ranks Range</h5>
                        {{-- <h2 class="text-white mb-2 f-w-300">{{ $pending_applications->count() }}</h2>
                        <i class="fa-solid fa-scroll f-70 text-white"></i> --}}
                        <table  class="table white-text-table">
                            <thead>
                                <tr>
                                    <th >RANK RANGE</th>
                                    <th>ECE</th>
                                    <th>EEE</th>
                                    <th>MECH</th>
                                    <th>CIVIL</th>
                                    <th>CSE</th>
                                    <th>IT</th>
                                    <th>AIML</th>
                                    <th>DS</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr>
                                    <td>1-100</td>
                                    <td>20</td>
                                    <td>3</td>
                                    <td>56</td>
                                    <td>77</td>
                                    <td>12</td>
                                    <td>33</td>
                                    <td>23</td>
                                    <td>23</td>
                                </tr>
                                <tr>
                                    <td>101-500</td>
                                    <td>34</td>
                                    <td>34</td>
                                    <td>65</td>
                                    <td>75</td>
                                    <td>33</td>
                                    <td>23</td>
                                    <td>87</td>
                                    <td>23</td>
                                </tr>
                                <tr>
                                    <td>501-1000</td>
                                    <td>12</td>
                                    <td>3</td>
                                    <td>56</td>
                                    <td>77</td>
                                    <td>98</td>
                                    <td>46</td>
                                    <td>32</td>
                                    <td>12</td>
                                </tr>
                                <tr>
                                    <td>1001-5000</td>
                                    <td>12</td>
                                    <td>33</td>
                                    <td>23</td>
                                    <td>87</td>
                                    <td>3</td>
                                    <td>56</td>
                                    <td>77</td>
                                    <td>98</td>
                                </tr>
                                <tr>
                                    <td>5001-10000</td>
                                    <td>45</td>
                                    <td>45</td>
                                    <td>34</td>
                                    <td>65</td>
                                    <td>2</td>
                                    <td>34</td>
                                    <td>34</td>
                                    <td>65</td>
                                </tr>
                                <tr>
                                    <td>10001-20000</td>
                                    <td>77</td>
                                    <td>98</td>
                                    <td>46</td>
                                    <td>3</td>
                                    <td>56</td>
                                    <td>77</td>
                                    <td>12</td>
                                    <td>3</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-red">
                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studen_emcet_rank_graph">
                                <span class="text-red">Edit</span>
                            </button>
                            @include('admin.charts.bargraf')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"> {{ __('status_active') }} {{ trans_choice('module_student', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $active_students->count() }}</h2>
                        <i class="fas fa-user-graduate f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">{{ __('status_active') }} {{ trans_choice('module_staff', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $active_staffs->count() }}</h2>
                        <i class="fas fa-user-tag f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">{{ __('field_total') }} {{ trans_choice('module_book', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $library_books->sum('quantity') }}</h2>
                        <i class="fas fa-book f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <!-- [ bitcoin-wallet section ] end-->
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">{{ __('field_daily') }} {{ trans_choice('module_visitor_log', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $daily_visitors->count() }}</h2>
                        <i class="fas fa-eye f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">{{ __('field_daily') }} {{ trans_choice('module_phone_log', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $daily_phone_logs->count() }}</h2>
                        <i class="fas fa-phone-volume f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">{{ __('field_daily') }} {{ trans_choice('module_enquiry', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $daily_enqueries->count() }}</h2>
                        <i class="fas fa-question f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">{{ __('field_daily') }} {{ trans_choice('module_postal_exchange', 2) }}</h5>
                        <h2 class="text-white mb-2 f-w-300">{{ $daily_postals->count() }}</h2>
                        <i class="fas fa-exchange-alt f-70 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        @canany(['fees-student-report', 'payroll-report'])
        <div class="row">
            <div class="col-12 col-md-12 col-xl-12">
                <canvas id="lineChart" height="100px"></canvas>
            </div>
        </div>
        @endcanany

        <div class="row">
            @canany(['fees-student-report'])
            <div class="col-12 col-md-6 col-xl-6 mt-5">
                <canvas id="pieChart" height="220px"></canvas>
            </div>
            @endcanany
            @canany(['payroll-report'])
            <div class="col-12 col-md-6 col-xl-6 mt-5">
                <canvas id="line-chartcanvas" height="250px"></canvas>
            </div>
            @endcanany
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<!-- chart Js -->
<script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script>


<script type="text/javascript">
      "use strict";
      var labels =  <?php echo $months ?>;
      var fees =  <?php echo $fees ?>;
      var salaries =  <?php echo $salaries ?>;
      var incomes =  <?php echo $incomes ?>;
      var expenses =  <?php echo $expenses ?>;

      const data = {

        labels: labels,

        datasets: [
            {

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
    var student_fee =  <?php echo $student_fee ?>;
    var discounts =  <?php echo $discounts ?>;
    var fines =  <?php echo $fines ?>;
    var fee_paid =  <?php echo $fee_paid ?>;

    const ctx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['{{ __('field_student') }} {{ __('field_fee') }}', '{{ __('field_discount') }}', '{{ __('field_fine_amount') }}', '{{ __('field_paid_amount') }}'],
            datasets: [{
                label: '# of Fees',
                data: [
                student_fee , discounts, fines, fee_paid],
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
$(function(){
    var labels =  <?php echo $months ?>;
    var net_salary = <?php echo $net_salary ?>;
    var total_allowance = <?php echo $total_allowance ?>;
    var total_deduction = <?php echo $total_deduction ?>;
    var total_tax = <?php echo $total_tax ?>;
    //get the line chart canvas
    var ctx = $("#line-chartcanvas");

    //line chart data
    var data = {
    labels: labels,
    datasets: [
        {
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
