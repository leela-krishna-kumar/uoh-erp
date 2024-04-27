@extends('admin.layouts.master')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@section('title','')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Staff Attendence Reports</h5>
                    </div>

                    <div class="card-block">                           
                        
                      <form class="needs-validation" novalidate method="get" action="{{ route($route) }}">
                        <div class="row gx-2">
                            <!-- <div class="form-group col-md-2">
                                <label for="role">{{ __('field_role') }}</label>
                                <select class="form-control" name="role" id="role">
                                    <option value="">{{ __('all') }}
                                    @foreach( $roles as $role )
                                    @if($role->slug != 'super-admin')
                                    <option value="{{ $role->id }}" @if( $selected_role == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endif
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_role') }}
                                </div>
                            </div> -->
                            <div class="form-group col-md-2">
                                <label for="department">{{ __('field_department') }} <span>*</span></label>
                                <select class="form-control" name="department" id="department" required>

                                  {{-- @if(!Auth::user()->hasRole('HoD'))
                                    <option value="">{{ __('all') }}</option>
                                  @endif --}}

                                  <option value="">{{ __('select') }}</option>
                                  
                                    @foreach( $departments as $department )
                                    <option value="{{ $department->id }}" @if( $selected_department == $department->id) selected @endif>{{ $department->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_department') }}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="designation">{{ __('field_designation') }}</label>
                                <select class="form-control" name="designation" id="designation">
                                    <option value="">{{ __('all') }}</option>
                                    @foreach( $designations as $designation )
                                    <option value="{{ $designation->id }}" @if( $selected_designation == $designation->id) selected @endif>{{ $designation->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_designation') }}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="shift">{{ __('field_work_shift') }}</label>
                                <select class="form-control" name="shift" id="shift">
                                    <option value="">{{ __('all') }}</option>
                                    @foreach( $work_shifts as $shift )
                                    <option value="{{ $shift->id }}" @if( $selected_shift == $shift->id) selected @endif>{{ $shift->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_work_shift') }}
                                </div>
                            </div>

                            {{-- <div class="form-group col-md-2">
                                <label for="date">{{ __('field_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="date" id="date" value="{{ $selected_date }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_date') }}
                                </div>
                            </div> --}}

                            <div class="form-group col-md-2">
                              <label for="month">{{ __('field_month') }} <span>*</span></label>
                              <select class="form-control" name="month" id="month" required>
                                  <option value="1" @if($selected_month == 1) selected @endif>{{ __('month_january') }}</option>
                                  <option value="2" @if($selected_month == 2) selected @endif>{{ __('month_february') }}</option>
                                  <option value="3" @if($selected_month == 3) selected @endif>{{ __('month_march') }}</option>
                                  <option value="4" @if($selected_month == 4) selected @endif>{{ __('month_april') }}</option>
                                  <option value="5" @if($selected_month == 5) selected @endif>{{ __('month_may') }}</option>
                                  <option value="6" @if($selected_month == 6) selected @endif>{{ __('month_june') }}</option>
                                  <option value="7" @if($selected_month == 7) selected @endif>{{ __('month_july') }}</option>
                                  <option value="8" @if($selected_month == 8) selected @endif>{{ __('month_august') }}</option>
                                  <option value="9" @if($selected_month == 9) selected @endif>{{ __('month_september') }}</option>
                                  <option value="10" @if($selected_month == 10) selected @endif>{{ __('month_october') }}</option>
                                  <option value="11" @if($selected_month == 11) selected @endif>{{ __('month_november') }}</option>
                                  <option value="12" @if($selected_month == 12) selected @endif>{{ __('month_december') }}</option>
                              </select>

                              <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_month') }}
                              </div>
                          </div>
                          <div class="form-group col-md-2">
                              <label for="year">{{ __('field_year') }} <span>*</span></label>
                              <select class="form-control" name="year" id="year" required>
                                  <option value="{{ date("Y") }}" @if($selected_year == date("Y")) selected @endif>{{ date("Y") }}</option>
                                  <option value="{{ date("Y") - 1 }}" @if($selected_year == date("Y") - 1) selected @endif>{{ date("Y") - 1 }}</option>
                                  <option value="{{ date("Y") - 2 }}" @if($selected_year == date("Y") - 2) selected @endif>{{ date("Y") - 2 }}</option>
                                  <option value="{{ date("Y") - 3 }}" @if($selected_year == date("Y") - 3) selected @endif>{{ date("Y") - 3 }}</option>
                                  <option value="{{ date("Y") - 4 }}" @if($selected_year == date("Y") - 4) selected @endif>{{ date("Y") - 4 }}</option>
                                  <option value="{{ date("Y") - 5 }}" @if($selected_year == date("Y") - 5) selected @endif>{{ date("Y") - 5 }}</option>
                                  <option value="{{ date("Y") - 6 }}" @if($selected_year == date("Y") - 6) selected @endif>{{ date("Y") - 6 }}</option>
                                  <option value="{{ date("Y") - 7 }}" @if($selected_year == date("Y") - 7) selected @endif>{{ date("Y") - 7 }}</option>
                                  <option value="{{ date("Y") - 8 }}" @if($selected_year == date("Y") - 8) selected @endif>{{ date("Y") - 8 }}</option>
                                  <option value="{{ date("Y") - 9 }}" @if($selected_year == date("Y") - 9) selected @endif>{{ date("Y") - 9 }}</option>
                              </select>

                              <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_year') }}
                              </div>
                          </div>

                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                            </div>
                        </div>
                    </form>
                  </div>

                </div>
            </div>

            


            <div class="card-block">

              <div class="row" >

                @if ($selected_department != 0)
                  
               
                {{-- @for ($i=0; $i<$graph_count-1 ;$i++)      --}}
              
                  <div class="col-md-4">                      
                  <a style="padding:5px;" target="_blank" href="{{ url('admin/staff-daily-report?department=14&designation=&shift=&date=2024-03-08&month=3&year=2024') }}" class="btn btn-success btn-filter">Tablular Report</a>

                    <!--Div that will hold the column chart-->
                    <div id="attendence1_barchart_material0" style="height:400px;padding-top:5px;"></div>
                  </div>

                  <div class="col-md-4">                      
                    <a style="padding:5px;" target="_blank" href="{{ url('admin/staff-daily-report?department=14&designation=&shift=&date=2024-03-08&month=3&year=2024') }}" class="btn btn-success btn-filter">Tablular Report</a>
  
                      <!--Div that will hold the column chart-->
                      <div id="attendence1_barchart_material1" style="height:400px;padding-top:5px;"></div>
                  </div>

                  <div class="col-md-4">                      
                    <a style="padding:5px;" target="_blank" href="{{ url('admin/staff-daily-report?department=14&designation=&shift=&date=2024-03-08&month=3&year=2024') }}" class="btn btn-success btn-filter">Tablular Report</a>
  
                      <!--Div that will hold the column chart-->
                      <div id="attendence1_barchart_material2" style="height:400px;padding-top:5px;"></div>
                  </div>

                {{-- @endfor --}}
                 @endif
          </div>

          </div>


        </div>
    </div>
</div>
<!-- End Content-->

@endsection


@section('sub-script')


<script>
  google.charts.load('current', { 'packages': ['bar'] });


google.charts.setOnLoadCallback(att0DrawChart);
google.charts.setOnLoadCallback(att1DrawChart);
google.charts.setOnLoadCallback(att2DrawChart);
// google.charts.setOnLoadCallback(att3DrawChart);

  var program = '<?php echo $dept_title; ?>';

  const currentDate = new Date();

  const year = currentDate.getFullYear();
const month = currentDate.getMonth() + 1; // Note: Month is zero-based, so January is 0
const day = currentDate.getDate();

function att0DrawChart() {

  // var $present_count = '<?php echo $staff_attendence_data_p_c; ?>';
  // var $absent_count = '<?php echo $staff_attendence_data_a_c; ?>';

  var $present_count = '<?php echo rand(20,30); ?>';
  var $absent_count = '<?php echo rand(1,5); ?>';

    var data = google.visualization.arrayToDataTable([
        ['Staff Type', 'Present', 'Absent'],
        ['Teaching', parseInt($present_count*1.5), parseInt($absent_count*1.6)],
        ['Non Teaching', parseInt($present_count*1.1), parseInt($absent_count*1.2)],
        // ['Section C', parseInt($present_count), parseInt($absent_count)],
        // ['ECE', 115, 86],
        // ['EEE', 66, 20],
        // ['Mechanical', 100, 54]
    ]);

    var options = {
        chart: {
            title: 'Daily Attendence - ' + day + '/'+month+'/'+year,
           // subtitle: 'Daily',
        },
      //  colors: ['#ffb1c1', '#9ad0f5'],
      colors:['#36a2eb', '#ff6384'],
      backgroundColor : { fill:'transparent' },
        bars: 'vertical' // Required for Material Bar Charts.
        
    };

    var chart = new google.charts.Bar(document.getElementById('attendence1_barchart_material0'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}

function att1DrawChart() {

  var $present_count = '<?php echo rand(450,500); ?>';
  var $absent_count = '<?php echo rand(100,150); ?>';

  var month = '<?php echo $selected_month; ?>';
  var year = '<?php echo $selected_year; ?>';

    var data = google.visualization.arrayToDataTable([
        ['Staff Type', 'Present', 'Absent'],
        ['Teaching', parseInt($present_count*1.5), parseInt($absent_count*1.6)],
        ['Non Teaching', parseInt($present_count*1.1), parseInt($absent_count*1.2)],
        // ['Section C', parseInt($present_count), parseInt($absent_count)],
        // ['ECE', 115, 86],
        // ['EEE', 66, 20],
        // ['Mechanical', 100, 54]
    ]);

  var options = {
      chart: {
        title: 'Monthly Attendence - ' + month+'/'+year,
         // subtitle: 'Daily',
      },
    //  colors: ['#ffb1c1', '#9ad0f5'],
    colors:['#36a2eb', '#ff6384'],
    backgroundColor : { fill:'transparent' },
      bars: 'vertical' // Required for Material Bar Charts.
      
  };

  var chart = new google.charts.Bar(document.getElementById('attendence1_barchart_material1'));

  chart.draw(data, google.charts.Bar.convertOptions(options));
}

function att2DrawChart() {

  var $present_count = '<?php echo rand(20,30); ?>';
  var $absent_count = '<?php echo rand(1,5); ?>';

    var data = google.visualization.arrayToDataTable([
        ['Staff Type', 'Present', 'Absent'],
        ['Teaching', parseInt($present_count*505), parseInt($absent_count*506)],
        ['Non Teaching', parseInt($present_count*301), parseInt($absent_count*202)],
        // ['Section C', parseInt($present_count), parseInt($absent_count)],
        // ['ECE', 115, 86],
        // ['EEE', 66, 20],
        // ['Mechanical', 100, 54]
    ]);

  var options = {
      chart: {
        title: 'Current Academic Year Attendence - '+(year-1)+'-'+(year),
         // subtitle: 'Daily',
      },
    //  colors: ['#ffb1c1', '#9ad0f5'],
    colors:['#36a2eb', '#ff6384'],
    backgroundColor : { fill:'transparent' },
      bars: 'vertical' // Required for Material Bar Charts.
      
  };

  var chart = new google.charts.Bar(document.getElementById('attendence1_barchart_material2'));

  chart.draw(data, google.charts.Bar.convertOptions(options));
}

function att3DrawChart() {

var $present_count = '<?php echo $std_attendence_data_p_c; ?>';
var $absent_count = '<?php echo $std_attendence_data_a_c; ?>';

  var data = google.visualization.arrayToDataTable([
      ['Sections', 'Present', 'Absent'],
      ['Section A', parseInt($present_count), parseInt($absent_count)],
      ['Section B', parseInt($present_count), parseInt($absent_count)],
      ['Section C', parseInt($present_count), parseInt($absent_count)],
      // ['ECE', 115, 86],
      // ['EEE', 66, 20],
      // ['Mechanical', 100, 54]
  ]);

  var options = {
      chart: {
        title: program + ' 4-1',
         // subtitle: 'Daily',
      },
    //  colors: ['#ffb1c1', '#9ad0f5'],
    colors:['#36a2eb', '#ff6384'],
    backgroundColor : { fill:'transparent' },
      bars: 'vertical' // Required for Material Bar Charts.
      
  };

  var chart = new google.charts.Bar(document.getElementById('attendence1_barchart_material3'));

  chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>


<script type="text/javascript">
    "use strict";
    $(".faculty").on('change',function(e){
      e.preventDefault(e);
      var program=$(".program");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-program') }}",
        data:{
          _token:$('input[name=_token]').val(),
          faculty:$(this).val()
        },
        success:function(response){
              console.log("Okk");
            // var jsonData=JSON.parse(response);
            $('option', program).remove();
            $('.program').append('<option value="">{{ __("Select") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.program');
            });
          }

      });
    });

    $(".program").on('change',function(e){
      e.preventDefault(e);
      var session=$(".session");
      var semester=$(".semester");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-session') }}",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', session).remove();
            $('.session').append('<option value="">{{ __("Select") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.session');
            });
          }

      });

      $.ajax({
        type:'POST',
        url: "{{ route('filter-semester') }}",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', semester).remove();
            $('.semester').append('<option value="">{{ __("Select") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.semester');
            });
          }

      });
      var student=$(".student");
      $.ajax({
            type:'POST',
            url: "{{ route('filter-students') }}",
            data:{
                _token:$('input[name=_token]').val(),
                program:$(this).val()
            },
            success:function(response){
                console.log(response);
                // var jsonData=JSON.parse(response);
                $('option', student).remove();
                $('.student').append('<option value="0">{{ __("all") }}</option>');
                $.each(response, function(){
                    $('<option/>', {
                    'value': this.id,
                    'text': this.first_name+' '+this.last_name
                    }).appendTo('.student');
                });
                }

            });
    });

    $(".semester").on('change',function(e){
      e.preventDefault(e);
      var section=$(".section");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-section') }}",
        data:{
          _token:$('input[name=_token]').val(),
          semester:$(this).val(),
          program:$('.program option:selected').val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', section).remove();
            $('.section').append('<option value="">{{ __("Select") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.section');
            });
          }

      });
    });
</script>
@endsection

@section('page_js')

@yield('sub-script')

@endsection