@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.change.section') }}">
                            <div class="row gx-2">
                                @include('common.inc.common_search_filter')

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                @isset($rows)
                <form action="{{ route($route.'.store') }}" method="post">
                @csrf
                @if(count($rows) > 0)
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                        <div class="checkbox checkbox-success d-inline">
                                            <input type="checkbox" id="checkbox" class="all_select" checked>
                                            <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                        </div>
                                        </th>
                                        <th>{{ __('field_student_id') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_gender') }}</th>
                                        <th>{{ __('field_total_credit_hour') }}</th>
                                        <th>{{ __('field_cumulative_gpa') }}</th>
                                        <th>{{ __('field_batch') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )

                                    @php
                                        $total_credits = 0;
                                        $total_cgpa = 0;
                                    @endphp
                                    @foreach( $row->studentEnrolls as $key => $item )

                                        @if(isset($item->subjectMarks))
                                        @foreach($item->subjectMarks as $mark)

                                            @php
                                            $marks_per = round($mark->total_marks);
                                            @endphp

                                            @foreach($grades as $grade)
                                            @if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark)
                                            @php
                                            if($grade->point > 0){
                                            $total_cgpa = $total_cgpa + ($grade->point * $mark->subject->credit_hour);
                                            $total_credits = $total_credits + $mark->subject->credit_hour;
                                            }
                                            @endphp
                                            @break
                                            @endif
                                            @endforeach

                                        @endforeach
                                        @endif

                                    @endforeach

                                    <input type="text" name="program" value="{{ $selected_program }}" hidden>
                                    <tr>
                                        <td>
                                        <div class="checkbox checkbox-primary d-inline">
                                            <input type="checkbox" name="students[]" id="checkbox-{{ $row->id }}" value="{{ $row->id }}" checked>
                                            <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                        </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.show', $row->id) }}" target="_blank">
                                            #{{ $row->student_id }}
                                            </a>
                                        </td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>
                                            @if( $row->gender == 1 )
                                            {{ __('gender_male') }}
                                            @elseif( $row->gender == 2 )
                                            {{ __('gender_female') }}
                                            @elseif( $row->gender == 3 )
                                            {{ __('gender_other') }}
                                            @endif
                                        </td>
                                        <td>{{ round($total_credits, 2) }}</td>
                                        <td>
                                            @php
                                            if($total_credits <= 0){
                                                $total_credits = 1;
                                            }
                                            $com_gpa = $total_cgpa / $total_credits;
                                            echo number_format((float)$com_gpa, 2, '.', '');
                                            @endphp
                                        </td>
                                        <td>{{ $row->batch->title ?? '' }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
                

                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('field_next_enrollment') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="row gx-2">
                            <div class="form-group col-md-3">
                                <label for="session">{{ __('field_session') }} <span>*</span></label>
                                <select class="form-control" name="session" id="session" required disabled>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session->id }}" @if($selected_session == $session->id) selected @endif>
                                            {{ $session->title }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="semester">{{ __('field_semester') }} <span>*</span></label>
                                <select class="form-control" name="semester" id="semester" required disabled>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" @if($selected_semester == $semester->id) selected @endif>
                                            {{ $semester->title }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_semester') }}
                                </div>
                            </div>
                            
                            
                            <div class="form-group col-md-3">
                                <label for="section">{{ __('field_section') }} <span>*</span></label>
                                <select class="form-control next_section" name="section" id="section" required>
                                  <option value="">{{ __('select') }}</option>
                                  @foreach( $sections as $section )
                                  <option value="{{ $section->id }}" @if( $selected_section == $section->id) selected @endif>{{ $section->title }}</option>
                                  @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_section') }}
                                </div>
                            </div>
                            {{-- <div class="form-group col-md-12">
                                <label for="subject">{{ __('field_subject') }} <span>* ({{ __('select_multiple') }})</span></label>
                                <select class="form-control select2 next_subject" name="subjects[]" id="subject" multiple required>
                                    @foreach( $subjects as $subject )
                                    <option value="{{ $subject->id }}">
                                        {{ $subject->code }} - {{ $subject->title }}
                                    </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_subject') }}
                                </div>
                            </div> --}}
                            <div class="form-group col-md-4">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                    <i class="fas fa-exchange"></i> Change Section
                                </button>
                                <!-- Include Confirm modal -->
                                   <!-- Confirm modal -->
                                    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <h5 class="modal-title" id="ConfirmModalLabel">{{ __('modal_are_you_sure') }}</h5>
                                                    <p class="text-danger mt-2">{{ __('modal_action_warning') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                                                    <button type="button" class="btn btn-danger btn-confirm"><i class="fas fa-check"></i> {{ __('btn_confirm') }}</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                </form>

                @if(count($rows) < 1)
                <div class="card">
                    <div class="card-block">
                        <h5>{{ __('no_result_found') }}</h5>
                    </div>
                </div>
                @endif
                @endisset

            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
@if(isset($row))
<script type="text/javascript">
"use strict";
// checkbox all-check-button selector
$(".all_select").on('click',function(e){
    if($(this).is(":checked")){
        // check all checkbox
        $("input:checkbox").prop('checked', true);
    }
    else if($(this).is(":not(:checked)")){
        // uncheck all checkbox
        $("input:checkbox").prop('checked', false);
    }
});

// Next Section
$(".next_semester").on('change',function(e){
  e.preventDefault(e);
  var section=$(".next_section");
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
      semester: $(this).val(),
      program: '{{ $selected_program }}'
    },
    success:function(response){
        // var jsonData=JSON.parse(response);
        $('option', section).remove();
        $('.next_section').append('<option value="">{{ __("select") }}</option>');
        $.each(response, function(){
          $('<option/>', {
            'value': this.id,
            'text': this.title
          }).appendTo('.next_section');
        });
      }

  });
});

// Next Subject
$(".next_section").on('change', function(e) {
    // Set the value of the input field with the ID 'section'
    $('#section').val($(this).val());

    // Prevent the default form submission
    e.preventDefault();

    // Rest of your code remains unchanged
    var data = {
        _token: $('input[name="_token"]').val(),
        section: $(this).val(),
        semester: $('.next_semester option:selected').val(),
        program: '{{ $selected_program }}'
    };

    $.ajax({
        type: 'POST',
        url: "{{ route('filter-enroll-subject') }}",
        data: data,
        success: function(response) {
            // Iterate over the response and select the corresponding subjects
            $.each(response, function() {
                $('.next_subject option[value=' + this.id + ']').attr('selected', 'selected');
            });

            // Trigger the change event for select2 to update the UI
            $('.next_subject').select2().trigger('change');
        },
        error: function(xhr, status, error) {
            // Handle the error response if needed
            console.error(xhr.responseText);
        }
    });
});



$(".btn-confirm").on('click', function() {
    // Extracting selected student IDs
    var selectedStudentIds = [];
    $('input[name="students[]"]:checked').each(function() {
        selectedStudentIds.push($(this).val());
    });

    // Additional data to be sent in the request
    var data = {
        _token: $('input[name="_token"]').val(),
        session: $('#session').val(),
        semester: $('#semester').val(),
        section: $('#section').val(),
        subjects: $('.next_subject').val(),
        students: selectedStudentIds
    };


    // Perform AJAX request
    $.ajax({
        type: 'POST',
        url: "{{ route('admin.store.section') }}",
        data: data,
        success: function(response) {
            // Handle the success response if needed
            console.log(response);

            toastr.success('Section has changed successfully');

        setTimeout(function () {
            window.location.href = "{{ route('admin.change.section') }}";
        }, 2000);
        },
        error: function(xhr, status, error) {
        var responseJson = xhr.responseJSON;

        toastr.error(responseJson && responseJson.message ? responseJson.message : 'An error occurred.');

        setTimeout(function () {
            window.location.href = "{{ route('admin.change.section') }}";
        }, 2000);
    }
    });

    $('#confirmModal').modal('hide');
});

</script>
@endif
@endsection