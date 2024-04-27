@extends('admin.layouts.master')
@section('title', 'Data Update')

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Update</h5>
                    </div>
                    <div class="card-block">
                        {{-- <a href="#" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a> --}}

                        <a href="/admin/dataUpdateAdmin" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                       <div style="margin-top: 10px;">
                        <h6><span style="color: red;">* Once data has been updated, it cannot be reverted.</span></h6>
                    </div>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route('admin.updateTableData') }}" method="post" enctype="multipart/form-data">
                      <div class="wizard-sec-bg">
                          @csrf
                          {{-- <content class="form-step"> --}}
                            <!-- Form Start -->
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                    <div class="form-group col-md-6">
                                        <label for="action_to_perform">Action<span>*</span></label>
                                            <select class="form-control" name="action" id="action_to_perform" required>
                                                <option value="">{{ __('select') }}</option>
                                                <option value="update">Update</option>
                                                <option value="insert">Insert</option>
                                                <option value="update_or_create">CreateOrUpdate</option>
                                            </select>
                                        <div class="invalid-feedback"> {{ __('field_status') }}
                                        </div>
                                    </div>
                                  <div class="form-group col-md-6">
                                    <label for="tableName">Select Table<span>*</span> </label>
                                    <select name="tableName" id="tabelName" class="form-control select2" name="tabelName" required>
                                        @php
                                            // $database_name = env('DB_DATABASE');
                                            $database_name = 'universityerp_main';
                                            $database_string = 'Tables_in_'.$database_name;
                                        @endphp
                                            <option value="" readonly>Select Table Name</option>
                                            @foreach ($tables as $table)
                                            <option value="{{$table->$database_string}}">{{$table->$database_string}}</option>
                                            @endforeach
                                    </select>

                                  </div>
                                  {{-- <div class="form-group col-md-6">
                                    <label for="number_of_columns" class="form-label">Enter Number of Columns<span>*</span></label>
                                    <input type="number" class="form-control autonumber" name="numberOfColumns" id="number_of_columns" required>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} Please Enter Number Of Columns
                                    </div>
                                </div> --}}

                                  <div class="form-group col-md-6" id="refd_dropdown">
                                    <label for="column_name">Select Refe Column</label>
                                        <select class="form-control" name="Refcolumn" id="column_name">
                                            <option value="">{{ __('select') }}</option>

                                        </select>
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6" id="update_columns_dropdown">
                                    <label for="update_columns" class="form-label">Select Columns To Update<span>*</span></label>
                                    <select class="form-control select2" name="update_columns[]" id="update_columns" multiple >
                                        <option value="">{{ __('select') }}</option>
                                    </select>
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="column_name_mul" class="form-label">Select Column Names<span>*</span></label>
                                    <select class="form-control select2" name="ColumnNamesMul[]" id="column_name_mul" multiple required>
                                        <option value="">{{ __('select') }}</option>
                                    </select>
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="import_file" class="form-label">Choose File<span>*</span></label>
                                    <input type="file" name="import" id="import_file" class="form-control" required>
                                    </div>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>Update</button>
                        </div>
                      </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')

<script>
    $( document ).ready(function() {
        document.getElementById('refd_dropdown').style.display = 'none';
        document.getElementById('update_columns_dropdown').style.display = 'none';

    });
    $('#action_to_perform').on('change',function(){
        // $('option', $("#column_name")).remove();
        // $('option', $("#tabelName")).remove();
        // $('option', $("#column_name_mul")).remove();
        $('#import_file').val('');
        var selectedValue = this.value;
        // console.log(selectedValue);
        if (selectedValue == "update"){
            document.getElementById('refd_dropdown').style.display = 'block';
            document.getElementById('update_columns_dropdown').style.display = 'none';
        } else if (selectedValue == "update_or_create" ){
            document.getElementById('refd_dropdown').style.display = 'block';
            document.getElementById('update_columns_dropdown').style.display = 'block';
        } else{
            document.getElementById('refd_dropdown').style.display = 'none';
            document.getElementById('update_columns_dropdown').style.display = 'none';
        }

    })
     $("#tabelName").on('change',function(e){

          e.preventDefault();
          var columnName=$("#column_name");
          var columnNameMul=$("#column_name_mul");
          var columnToUpdate=$("#update_columns");

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:'POST',
            url: "{{ route('admin.getTableColumns') }}",
            data:{
              _token:$('input[name=_token]').val(),
              tableName:$(this).val()
            },
            success: function(response) {
                // console.log('response');
              $('option', columnName).remove();
              $('option', columnNameMul).remove();
              $('option', columnToUpdate).remove();
              $('#import_file').val('');
              $('#column_name').append('<option value="">{{ __("select") }}</option>');
              $('#column_name_mul').append('<option value="">{{ __("select") }}</option>');
              $('#update_columns').append('<option value="">{{ __("select") }}</option>');


              $.each(response, function(key, value) {
                  var option_1 = $('<option/>', {
                      'value': value,
                      'text': value
                  });
                  var option_2 = $('<option/>', {
                      'value': value,
                      'text': value
                  });
                  var option_3 = $('<option/>', {
                      'value': value,
                      'text': value
                  });

                option_1.appendTo('#column_name');
                option_2.appendTo('#column_name_mul');
                option_3.appendTo('#update_columns');

              });
              var selectedAction =  $('#action_to_perform').val();
                console.log(selectedAction);
                var columnDropdown = document.getElementById('column_name_mul');
                var optionToHide = columnDropdown.querySelector('option[value="id"]');
                console.log(optionToHide);
                if (selectedAction == 'insert' && optionToHide) {
                    console.log("inside if");
                    optionToHide.style.display = 'none';
                }
            }

          });
        });
</script>

@endsection
