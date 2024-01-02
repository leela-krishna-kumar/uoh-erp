<div class="form-group col-md-3">
    <label for="faculty">{{ __('field_faculty') }}</label>
    <select class="form-control faculty" name="faculty" id="faculty">
      <option value="0">{{ __('all') }}</option>
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
    <label for="program">{{ __('field_program') }}</label>
    <select class="form-control program" name="program" id="program">
      <option value="0">{{ __('all') }}</option>
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
    <label for="subject">{{ __('Subject') }} <span>*</span></label>
    <select class="form-control subject" name="subject" id="subject" required>
      <option value="0">{{ __('all') }}</option>
      @if(isset($subjects))
      @foreach( $subjects->sortBy('code') as $subject )
      <option value="{{ $subject->id }}" @if( $selected_subject == $subject->id) selected @endif>{{ $subject->code }} - {{ $subject->title }}</option>
      @endforeach
      @endif
    </select>
  
    <div class="invalid-feedback">
      {{ __('required_field') }} {{ __('Subject') }}
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
                console.log("Okk");
              // var jsonData=JSON.parse(response);
              $('option', program).remove();
              $('.program').append('<option value="">{{ __("all") }}</option>');
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
        var session=$(".subject");
        var semester=$(".semester");
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type:'POST',
          url: "{{ route('filter-subject') }}",
          data:{
            _token:$('input[name=_token]').val(),
            program:$(this).val()
          },

          success:function(response){
              // var jsonData=JSON.parse(response);
              $('option', session).remove();
              $('.subject').append('<option value="">{{ __("all") }}</option>');
              $.each(response, function(){
                $('<option/>', {
                  'value': this.id,
                  'text': this.title
                }).appendTo('.subject');
              });
            }
  
        });
      });
  
  </script>