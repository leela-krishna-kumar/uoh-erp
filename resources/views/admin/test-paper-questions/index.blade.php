@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-12">
                <form class="needs-validation" novalidate action="{{route('admin.test-paper-question.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="testpaper_id" value="{{$testPaper->id}}">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }} for {{$testPaper->title}}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="radio">{{ __('Select Your Choice') }}</label><span>*</span> <br><br>
                                <input type="hidden" name=""id="radio">
                                <div class="radio-primary d-inline">
                                    <input type="radio" id="manual" name="type" value="manual"checked>
                                    <label for="manual">Manual Question Selection</label>
                                  </div>
                              
                                  <div class="radio-primary d-inline">
                                    <input type="radio" id="smart" name="type" value="smart">
                                    <label for="smart">Smart Bulk Question Picker</label>
                                  </div>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Choice') }}
                                </div>
                            </div>

                            <div class="form-group manual-question">
                                <label for="question_bank_id" class="form-label">{{ __('Select Questions') }} <span>*</span></label>
                                <select class="form-control" name="question_bank_id" id="question_bank_id">
                                    <option value="">{{ __('Select Question') }}</option>
                                    @foreach($questions as $question)
                                        <option value="{{ $question->id }}" @if(old('question_bank_id') == $question->id) selected @endif>
                                          #QID{{ $question->id }} - {{ Str::limit(strip_tags($question->question), 100, '...') }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Questions') }}
                                </div>
                            </div>


                            <div class="show-questions d-none">
                                <div class="row">
                                @include('common.inc.question_search_filter')
                                

                                {{-- <div class="form-group col-md-4">
                                    <label for="level">{{ __('Question Level') }} <span>*</span></label>
                                    <select class="form-control" name="level" id="level">
                                        <option value="">{{ __('Select Level') }}</option>
                                        <option value="Low" >{{ __('Low') }}</option>
                                        <option value="Medium" >{{ __('Medium') }}</option>
                                        <option value="High" >{{ __('High') }}</option>
                                    </select>
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Question Level') }}
                                    </div>
                                </div> --}}

                                <div class="form-group col-md-4">
                                    <strong class="fw-800 text-muted">Difficulty Level: <span class="text-success">Easy</span></strong>
                                    <label for="level">{{ __('Number of questions to be picked') }} <span>*</span></label>
                                    <input value="" required type="number" name="no_of_questions[Easy]" class="form-control"min="0">
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Question') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                  <strong class="fw-800 text-muted">Difficulty Level: <span class="text-warning">Medium</span></strong>
                                    <label for="level">{{ __('Number of questions to be picked') }} <span>*</span></label>
                                    <input value="" required type="number" name="no_of_questions[Medium]" class="form-control" min="0">
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Question') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                  <strong class="fw-800 text-muted">Difficulty Level: <span class="text-danger">Hard</span></strong>
                                    <label for="level">{{ __('Number of questions to be picked') }} <span>*</span></label>
                                    <input value="" required type="number" name="no_of_questions[Hard]" class="form-control" min="0">
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Question') }}
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                            <!-- Form End -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $testPaper->title }} {{ __('Question List') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Subjects') }}</th>
                                        <th>{{ __('Questions') }}</th>
                                        <th>{{ __('Difficulty Level') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ @$row->questions->subject->title}}</td>
                                        <td>{{ Str::limit(strip_tags($row->questions->question), 100, '...') }}</td>
                                        <td>{{ $row->questions->level }}</td>
                                        <td>
                                            @can($access.'-edit')
                                            <!--<button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">-->
                                            <!--    <i class="far fa-edit"></i>-->
                                            <!--</button>-->
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan
                                            @can($access.'-delete')
                                                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}"><i class="fas fa-trash-alt"></i>
                                                </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $(document).ready(function() {
        $('#question_bank_id').prop('required', true);
        $('#faculty').prop('required', false);
        $('#program').prop('required', false);
        $('#session').prop('required', false);
        $('#subject').prop('required', false);
        $('#semester').prop('required', false);
        $("input[name='type']").click(function() {
            var type = $(this).val();
            if(type == 'smart'){
                $('#question_bank_id').prop('required', false);
                $('#faculty').prop('required', true);
                $('#program').prop('required', true);
                $('#session').prop('required', true);
                $('#subject').prop('required', true);
                $(".manual-question").addClass('d-none');
                $(".show-questions").removeClass('d-none');
            }else{
                $('#question_bank_id').prop('required', true);
                $('#faculty').prop('required', false);
                $('#program').prop('required', false);
                $('#session').prop('required', false);
                $('#subject').prop('required', false);
                $('#semester').prop('required', false);
                
                $(".show-questions").addClass('d-none');
                $(".manual-question").removeClass('d-none');
            }
        });
    });

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
            $('.session').append('<option value="">{{ __("all") }}</option>');
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
            $('.semester').append('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.semester');
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
            $('.section').append('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.section');
            });
          }

      });
    });
    $("#subjectId").on('change',function(e){
      e.preventDefault(e);
      var subjectId = $("#subjectId").val();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-question-subject') }}",
        data:{
          _token:$('input[name=_token]').val(),
          subject_id:subjectId,
        },
        success:function(response){
          $('option', subjectId).remove();
            $('.question').html('<option value="">{{ __("all") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.question
              }).appendTo('.question');
            });
          }

      });
    });
</script>
@endsection