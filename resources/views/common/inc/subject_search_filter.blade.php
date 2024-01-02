<div class="form-group col-md-3">
  <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
  <select class="form-control faculty" name="faculty" id="faculty" required>
		<option value="">{{ __('select') }}</option>  
		<!-- <option value="">{{ __('All') }}</option>   -->
		@if(isset($faculties))
		@foreach( $faculties->sortBy('title') as $faculty )
		<option value="{{ $faculty->id }}" @if( $selected_faculty == $faculty->id) selected @endif>{{ $faculty->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_faculty') }}
	</div>
</div>
<div class="form-group col-md-3">
  <label for="program">{{ __('field_program') }} <span>*</span></label>
  <select class="form-control program" name="program" id="program" required>
		<option value="">{{ __('select') }}</option>
		<!-- <option value="">{{ __('All') }}</option> -->
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
<div class="form-group col-md-3">
  <label for="session">{{ __('field_session') }} <span>*</span></label>
  <select class="form-control session" name="session" id="session" required>
		<option value="">{{ __('select') }}</option>
    <!-- <option value="">{{ __('All') }}</option> -->
		@if(isset($sessions))
		@foreach( $sessions->sortByDesc('id') as $session )
		<option value="{{ $session->id }}" @if( $selected_session == $session->id) selected @endif>{{ $session->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_session') }}
	</div>
</div>
<div class="form-group col-md-3">
  <label for="semester">{{ __('field_semester') }} <span>*</span></label>
  <select class="form-control semester" name="semester" id="semester" required>
    <option value="">{{ __('select') }}</option>
		<!-- <option value="">{{ __('All') }}</option> -->
		@if(isset($semesters))
		@foreach( $semesters->sortBy('id') as $semester )
		<option value="{{ $semester->id }}" @if( $selected_semester == $semester->id) selected @endif>{{ $semester->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_semester') }}
	</div>
</div>
<div class="form-group col-md-3">
  <label for="section">{{ __('field_section') }} <span>*</span></label>
	<select class="form-control section" name="section" id="section" required>
    <option value="">{{ __('select') }}</option>
		<!-- <option value="">{{ __('All') }}</option> -->
		@if(isset($sections))
		@foreach( $sections->sortBy('title') as $section )
		<option value="{{ $section->id }}" @if( $selected_section == $section->id) selected @endif>{{ $section->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_section') }}
	</div>
</div>
<div class="form-group col-md-3">
  <label for="subject">{{ __('field_subject') }} <span>*</span></label>
  <select class="form-control subject" name="subject" id="subject" required>
    <option value="">{{ __('select') }}</option>
    @if(isset($subjects))
    @foreach( $subjects->sortBy('code') as $subject )
    <option value="{{ $subject->id }}" @if( $selected_subject == $subject->id) selected @endif>{{ $subject->code }} - {{ $subject->title }}</option>
    @endforeach
    @endif
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_subject') }}
  </div>
</div>
<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>

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

      // $.ajax({
      //   type:'POST',
      //   url: "{{ route('filter-subject') }}",
      //   data:{
      //     _token:$('input[name=_token]').val(),
      //     program:$(this).val()
      //   },
      //   success:function(response){
      //       var classTypeMap = {
      //         1: "{{ __('class_type_theory') }}",
      //         2: "{{ __('class_type_practical') }}",
      //         3: "{{ __('class_type_both') }}"
      //     };
      //       // var jsonData=JSON.parse(response);
      //       $('option', subject).remove();
      //       $.each(response, function(){
      //         var classTypeName = classTypeMap[this.class_type];
      //         $('<option/>', {
      //           'value': this.id,
      //           'text': this.code +' - '+ this.title +' - '+ classTypeName
      //         }).appendTo('.subject');
      //       });
      //     }

      // });
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

    $(".section").on('change',function(e){
      e.preventDefault(e);
      var subject=$(".subject");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        type:'POST',
        url: "{{ route('filter-enroll-subject') }}",
        data:{
          _token:$('input[name=_token]').val(),
          program:$('.program option:selected').val(),
          semester:$('.semester option:selected').val(),
          section:$(this).val()
        },
        success:function(response){
            var classTypeMap = {
              1: "{{ __('class_type_theory') }}",
              2: "{{ __('class_type_practical') }}",
              3: "{{ __('class_type_both') }}"
          };
            // var jsonData=JSON.parse(response);
            $('option', subject).remove();
            $('.subject').append('<option value="">{{ __("Select") }}</option>');
            $.each(response, function(){
              var classTypeName = classTypeMap[this.class_type];
              $('<option/>', {
                'value': this.id,
                'text': this.code +' - '+ this.title +' - '+ classTypeName
              }).appendTo('.subject');
            });
          }

      });
    });
</script>