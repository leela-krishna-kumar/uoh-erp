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
                        <h5>Student Attendence Reports</h5>
                    </div>

                    <div class="card-block">

                            
                        
                      <form class="needs-validation" novalidate method="get" action="{{ route($route) }}">
                          <div class="row gx-2">
                              <div class="form-group col-md-2">
                                  <label for="faculty">{{ __('field_course') }}</label>
                                  <select class="form-control faculty" name="faculty" id="faculty">
                                    <option value="">{{ __('select') }}</option>
                                    <!-- <option value="all" @if( $selected_faculty == 'all')selected @endif>{{ __('all') }}</option> -->
                                    @if(isset($faculties))
                                    @foreach($faculties->sortBy('title') as $faculty )
                                    <option value="{{ $faculty->id }}" @if( $selected_faculty == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                    @endforeach
                                    @endif
                                  </select>
                                
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_course') }}
                                  </div>
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="program">{{ __('field_program') }}</label>
                                  <select class="form-control program" name="program" id="program">
                                    <option value="">{{ __('select') }}</option>
                                    <!-- <option value="all" @if( $selected_program == 'all')selected @endif>{{ __('all') }}</option> -->
                                    @if(isset($programs))
                                      @foreach( $programs->sortBy('title') as $program )
                                      <option value="{{ $program->id }}" @if( $selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_program') }}
                                  </div>
                                </div>
      
                                <div class="form-group col-md-2">
                                  <label for="session">{{ __('field_academic') }} {{ __('field_year') }}</label>
                                  <select class="form-control session" name="session" id="session">
                                    <option value="">{{ __('select') }}</option>
                                    <!-- <option value="all" @if( $selected_session == 'all')selected @endif>{{ __('all') }}</option> -->
                                    @if(isset($sessions))
                                    @foreach( $sessions->sortByDesc('id') as $session )
                                    <option value="{{ $session->id }}" @if( $selected_session == $session->id) selected @endif>{{ $session->title }}</option>
                                    @endforeach
                                    @endif
                                  </select>
                                
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_academic') }} {{ __('field_year') }}
                                  </div>
                                </div>
      
                                <div class="form-group col-md-2">
                                  <label for="date">{{ __('field_date') }} <span>*</span></label>
                                  <input type="date" class="form-control date" name="date" value="{{ $selected_date }}" required>
      
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_date') }}
                                  </div>
                              </div>
      
                              
      
                              <div class="form-group col-md-2">
                                  <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                              </div>

                              {{-- @if (isset($graph_count))
                                <div class="form-group col-md-2">
                                  <a href="submit" class="btn btn-success btn-filter">Tablular Report</a>
                                </div>                                
                              @endif --}}

                          </div>
                      </form>
                  </div>

                </div>
            </div>

            


            <div class="card-block">

              <div class="row" >

                @for ($i=0; $i<$graph_count-1 ;$i++)     
              
                  <div class="col-md-4">

                      
                  <a style="padding:5px;" target="_blank" href="{{ url('admin/student-attendance-report?faculty=1&program=11&session=21&semester=17&section=3&subject=158&month=3&year=2024') }}" class="btn btn-success btn-filter">Tablular View</a>

                    <!--Div that will hold the column chart-->
                    <div id="attendence1_barchart_material{{$i}}" style="height:300px;padding-top:5px;"></div>
                  </div>
                @endfor
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
google.charts.setOnLoadCallback(att3DrawChart);

  var program = '<?php echo $program_title; ?>';

function att0DrawChart() {

  // var $present_count = '<?php echo $std_attendence_data_p_c; ?>';
  // var $absent_count = '<?php echo $std_attendence_data_a_c; ?>';

  var $present_count = '<?php echo rand(40,60); ?>';
  var $absent_count = '<?php echo rand(1,5); ?>';
  

    var data = google.visualization.arrayToDataTable([
        ['Sections', 'Present', 'Absent'],
        ['Section A', parseInt($present_count*1.5), parseInt($absent_count*1.3)],
      ['Section B', parseInt($present_count*1.3), parseInt($absent_count*1.2)],
      ['Section C', parseInt($present_count*1.4), parseInt($absent_count*1.5)],
        // ['ECE', 115, 86],
        // ['EEE', 66, 20],
        // ['Mechanical', 100, 54]
    ]);

    var options = {
        chart: {
            title: program + ' 1-1',
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

  var $present_count = '<?php echo rand(40,60); ?>';
  var $absent_count = '<?php echo rand(1,5); ?>';

  var data = google.visualization.arrayToDataTable([
      ['Sections', 'Present', 'Absent'],
      ['Section A', parseInt($present_count*1.5), parseInt($absent_count*1.3)],
      ['Section B', parseInt($present_count*1.3), parseInt($absent_count*1.2)],
      ['Section C', parseInt($present_count*1.4), parseInt($absent_count*1.5)],
      // ['ECE', 115, 86],
      // ['EEE', 66, 20],
      // ['Mechanical', 100, 54]
  ]);

  var options = {
      chart: {
        title: program + ' 2-1',
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

  var $present_count = '<?php echo rand(40,60); ?>';
  var $absent_count = '<?php echo rand(1,5); ?>';

  var data = google.visualization.arrayToDataTable([
      ['Sections', 'Present', 'Absent'],
      ['Section A', parseInt($present_count*1.5), parseInt($absent_count*1.3)],
      ['Section B', parseInt($present_count*1.3), parseInt($absent_count*1.2)],
      ['Section C', parseInt($present_count*1.4), parseInt($absent_count*1.5)],
      // ['ECE', 115, 86],
      // ['EEE', 66, 20],
      // ['Mechanical', 100, 54]
  ]);

  var options = {
      chart: {
        title: program + ' 3-1',
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

  var $present_count = '<?php echo rand(40,60); ?>';
  var $absent_count = '<?php echo rand(1,5); ?>';

  var data = google.visualization.arrayToDataTable([
      ['Sections', 'Present', 'Absent'],
      ['Section A', parseInt($present_count*1.5), parseInt($absent_count*1.3)],
      ['Section B', parseInt($present_count*1.3), parseInt($absent_count*1.2)],
      ['Section C', parseInt($present_count*1.4), parseInt($absent_count*1.5)],
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