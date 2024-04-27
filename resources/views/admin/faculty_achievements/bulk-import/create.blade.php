@extends('admin.layouts.master')
@section('content')





<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Student Bulk Upload</h5>
                    </div>
                    <div class="card-block">
                        <div class="form-group col-md-4 mx-auto">
                            <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
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
                        <div class="d-flex justify-content-center">
                            <div class="form-group col-md-4 mx-auto">
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
                        </div>
                          <div class="form-group col-md-4 mx-auto">
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
                          <div class="form-group col-md-4 mx-auto">
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
                          <div class="form-group col-md-4 mx-auto">
                            <label for="semester">{{ __('field_semester') }} <span>*</span></label>
                            <select class="form-control semester" name="semester" id="semester" required>
                              <option value="">{{ __('select') }}</option>
                                  @if(isset($semesters))
                                  @foreach( $semesters->sortBy('id') as $semester )
                                      <option value="{{ $semester->id }}">{{ $semester->title }}</option>
                                  @endforeach
                                  @endif
                              </select>
                          
                              <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_semester') }}
                              </div>
                          </div>
                          <div class="form-group col-md-4 mx-auto">
                            <label for="section">{{ __('field_section') }} <span>*</span></label>
                              <select class="form-control section" name="section" id="section" required>
                              <option value="">{{ __('select') }}</option>
                                  @if(isset($sections))
                                  @foreach($sections->sortBy('title') as $section)
                                      <option value="{{ $section->id }}">{{ $section->title }}</option>
                                  @endforeach
                                  @endif
                              </select>
                          
                              <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_section') }}
                              </div>
                          </div> 
                          <div class="form-group col-md-4 mx-auto">
                            <input type="file" name="image" id="uploadForm"> 
                        </div>
                    </div>
                    <div class="card-footer">
                        <center><button type="button" id="uploadButton">Upload </button></center>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
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
            $.ajax({
                type:'POST',
                url: "{{ route('filter-semester') }}",
                data:{
                _token:$('input[name=_token]').val(),
                    batch: selectedBatch,
                    faculty: selectedFaculty,
                    program: selectedProgram
                },
                dataType: 'json',
                success: function(response) {
                    $('#semester').empty().append('<option value="">{{ __('select') }}</option>');
                    $.each(response, function (index, item) {
                        $('#semester').append('<option value="' + item.id + '">' + item.title + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Error making API call:', error);
                }
            });
        }
    });

    $('#semester').change(function() {
        // Get the selected values from all dropdowns
        var selectedFaculty = $('#faculty').val();
        var selectedProgram = $('#program').val();
        var selectedBatch = $('#batch').val();
        var selectedSession = $('#session').val();
        var selectedSemester = $('#semester').val();

        $.ajax({
            type:'POST',
            url: "{{ route('filter-section') }}",
            data:{
            _token:$('input[name=_token]').val(),
                faculty: selectedFaculty,
                program: selectedProgram,
                batch: selectedBatch,
                session: selectedSession,
                semester: selectedSemester
            },
            dataType: 'json',
            success: function (response) {
                $('#section').empty().append('<option value="">{{ __('select') }}</option>');
                console.log('hi');
                $.each(response, function (index, item) {
                    console.log(item);
                    $('#section').append('<option value="' + item.id + '">' + item.title + '</option>');
                });
            },
            error: function (error) {
                console.error('Error fetching sections:', error);
            }
        });
    });
});

    $("#uploadButton").on("click", function () {
            var formData = new FormData();
            var fileInput = $('#uploadForm')[0];
            console.log(fileInput.files[0]);
            formData.append('import', fileInput.files[0]);
            formData.append('batch', $('#batch').val());
            formData.append('faculty', $('#faculty').val());
            formData.append('program', $('#program').val());
            formData.append('session', $('#session').val());
            formData.append('semester', $('#semester').val());
            formData.append('section', $('#section').val());
            formData.append('_token', $('input[name=_token]').val());

            $.ajax({
                url: "/admin/setting/bulk-import/students",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    // Handle success, if needed
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error, if needed
                }
            });
        });
</script>
@endsection