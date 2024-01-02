<!-- Filter Search -->
<script type="text/javascript">
    "use strict";
    $(".batch").on('change',function(e){
      e.preventDefault(e);
      var program=$(".program");
      var selected_program = "{{@$student->program_id}}";
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-batch') }}",
        data:{
          _token:$('input[name=_token]').val(),
          batch:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option',program).remove();
            $('.program').append('<option value="">{{ __("select") }}</option>');
            // $.each(response, function(){
            //   $('<option/>', {
            //     'value': this.id,
            //     'text': this.title
            //   }).appendTo('.program');
            // });
            $.each(response, function(){
              var option = $('<option/>', {
                'value': this.id,
                'text': this.title
              });
              // Check if the current option's ID matches selected_program
              if (this.id == selected_program) {
                option.attr('selected', 'selected');
              }
              option.appendTo('.program');
            });
          }

      });
    });

    $(".program").on('change',function(e){
      e.preventDefault(e);
      var session=$(".session");
      var semester=$(".semester");
      var session=$(".subject");
      var selected_semester_id = "{{@$student->semester_id}}";
      var selected_session_id = "{{@$student->session_id}}";
      // CSRF token
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      // Session
      $.ajax({
        type:'POST',
        url: "{{ route('filter-session') }}",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option',session).remove();
            $('.semester').append('<option value="">{{ __("select") }}</option>');
            // $.each(response, function(){
            //   $('<option/>', {
            //     'value': this.id,
            //     'text': this.title
            //   }).appendTo('.session').change();
            // });
            $.each(response, function(){
              var option = $('<option/>', {
                'value': this.id,
                'text': this.title
              });
              // Check if the current option's ID matches selected_session_id
              if (this.id == selected_session_id) {
                option.attr('selected', 'selected');
              }
              option.appendTo('.session').change();
            });
          }
      });
      // Semester
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
            $('.semester').append('<option value="">{{ __("select") }}</option>');
            // $.each(response, function(){
            //   $('<option/>', {
            //     'value': this.id,
            //     'text': this.title
            //   }).appendTo('.semester');
            // });
            $.each(response, function(){
              var option = $('<option/>', {
                'value': this.id,
                'text': this.title
              });
              // Check if the current option's ID matches selected_semester_id
              if (this.id == selected_semester_id) {
                option.attr('selected', 'selected');
              }
              option.appendTo('.semester').change();
            });
          }

      });
      // Subject
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
              $.each(response, function(){
                $('<option/>', {
                  'value': this.id,
                  'text': this.title
                }).appendTo('.subject');
              });
            }
  
      });
    });


    $(".semester").on('change',function(e){
      e.preventDefault(e);
      var section=$(".section");
      var selected_section_id = "{{@$student->section_id}}";
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
            $('.section').append('<option value="">{{ __("select") }}</option>');
            $.each(response, function(){
              var option = $('<option/>', {
                'value': this.id,
                'text': this.title
              });
              // Check if the current option's ID matches selected_section_id
              if (this.id == selected_section_id) {
                option.attr('selected', 'selected');
              }
              option.appendTo('.section');
            });
          }

      });
    });

  $(".section").on('change',function(e){
      e.preventDefault(e);
      var managed_by=$("#managed_by");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-teacher') }}",
        data:{
          _token:$('input[name=_token]').val(),
          section_id:$(this).val(),
          program_id:$('.program option:selected').val(),
          semester_id:$('.semester option:selected').val()
        },
        success:function(response){
            $('option', managed_by).remove();
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.first_name + ' ' + this.last_name
              }).appendTo('#managed_by');
            });
          }

      });
  });
</script>