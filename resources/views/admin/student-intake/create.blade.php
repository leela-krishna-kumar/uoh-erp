@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form id="uploadForm" class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                        <div class="wizard-sec-bg">
                          @csrf
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                  <div class="form-group col-md-6">
                                    <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
                                    <?php $faculties = \App\Models\Faculty::where('status', '1')->orderBy('title', 'asc')->get(); ?>
                                    <select class="form-control faculty" name="faculty" id="faculty" required>
                                        <option value="">{{ __('select') }}</option>
                                        @if(isset($faculties))
                                        @foreach($faculties->sortBy('title') as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_faculty') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="batch">{{ __('field_batch') }} <span>*</span></label>
                                    <select class="form-control batch" name="batch" id="batch" required>
                                        <option value="">{{ __('select') }}</option>
                                        @if(isset($batches))
                                        @foreach( $batches->sortBy('title') as $batch )
                                            <option value="{{ $batch->id }}">{{ $batch->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_faculty') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="program">{{ __('field_program') }} <span>*</span></label>
                                    <select class="form-control program" name="program" id="program" required>
                                        <option value="">{{ __('select') }}</option>
                                        @if(isset($programs))
                                        @foreach( $programs->sortBy('title') as $program )
                                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_program') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="session">{{ __('field_session') }}<span>*</span></label>
                                    <select class="form-control session" name="session" id="session" required>
                                    <option value="">{{ __('select') }}</option>
                                    @if(isset($sessions))
                                    @foreach( $sessions->sortByDesc('id') as $session )
                                    <option value="{{ $session->id }}" >{{ $session->title }}</option>
                                    @endforeach
                                    @endif
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="session">Intake Count<span>*</span></label>
                                    <input type="number" class="form-control" id="intake_count" name="intake_count">

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                    </div>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer">
                            <center><button type="submit" class="btn btn-primary" id="uploadButton">Save</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    // Function to update the options of a dropdown based on the selected value
    function updateDropdownOptions(dropdown, endpoint, dependentDropdown) {
        var selectedValue = $(dropdown).val();

        // Clear dependent dropdown options
        $(dependentDropdown).empty().append('<option value="">{{ __('select') }}</option>');

        if (selectedValue) {
            // Make an AJAX request to the specified endpoint
            $.ajax({
                url: endpoint + '/' + selectedValue,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Update the options of the dependent dropdown
                    $.each(response.data, function(index, item) {
                        $(dependentDropdown).append('<option value="' + item.id + '">' + item.title + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    }

    // Event listeners for each dropdown
    $('#faculty').change(function() {
        var selectedFaculty = $('#faculty').val();

        if (selectedFaculty) {
            $.ajax({
                type:'POST',
                url: "{{ route('filter-faculty') }}",
                data:{
                _token:$('input[name=_token]').val(),
                    faculty: selectedFaculty,
                },
                dataType: 'json',
                success: function(response) {
                    $('#batch').empty().append('<option value="">{{ __('select') }}</option>');
                    $.each(response, function (index, item) {
                        $('#batch').append('<option value="' + item.id + '">' + item.title + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Error making API call:', error);
                }
            });
        }
    });

    $('#batch').change(function() {
        var selectedBatch = $('#batch').val();

        if (selectedBatch) {
            // Make an AJAX request to your API endpoint with the selected values
            $.ajax({
                type:'POST',
                url: "{{ route('filter-batch') }}",
                data:{
                _token:$('input[name=_token]').val(),
                    batch: selectedBatch
                },
                dataType: 'json',
                success: function(response) {
                    $('#program').empty().append('<option value="">{{ __('select') }}</option>');
                    $.each(response, function (index, item) {
                        $('#program').append('<option value="' + item.id + '">' + item.title + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Error making API call:', error);
                }
            });
        }
    });
    $('#program').change(function() {
        var selectedBatch = $('#batch').val();
        var selectedFaculty = $('#faculty').val();
        var selectedProgram = $('#program').val();

        if (selectedProgram) {
            $.ajax({
                type:'POST',
                url: "{{ route('filter-session') }}",
                data:{
                _token:$('input[name=_token]').val(),
                    batch: selectedBatch,
                    faculty: selectedFaculty,
                    program: selectedProgram
                },
                dataType: 'json',
                success: function(response) {
                    $('#session').empty().append('<option value="">{{ __('select') }}</option>');
                    $.each(response, function (index, item) {
                        $('#session').append('<option value="' + item.id + '">' + item.title + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Error making API call:', error);
                }
            });
        }
    });

});

$("#uploadButton").on("click", function () {
            var formData = new FormData();
            var fileInput = $('#uploadForm')[0];
            formData.append('batch', $('#batch').val());
            formData.append('faculty', $('#faculty').val());
            formData.append('program', $('#program').val());
            formData.append('session', $('#session').val());
            formData.append('intake_count', $('#intake_count').val());
            formData.append('_token', $('input[name=_token]').val());

            $.ajax({
                url: "/admin/student-intake",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success('Student Intake has saved successfully');

                    setTimeout(function () {
                        window.location.href = "/admin/student-intake";
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    // toastr.error('Failed');

                    // setTimeout(function () {
                    //     window.location.href = "/admin/student-intake";
                    // }, 2000);
                }
            });
        });
</script>
@endsection
