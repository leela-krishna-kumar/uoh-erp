@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_name') }}
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="type" class="form-label">{{ __('field_type') }} <span>*</span> </label>
                                <select class="form-control submissionType" name="type" id="type" required >
                                    <option value="">{{ __('select') }}</option>
                                    @foreach (App\Models\AchievementCategory::TYPES as $key => $type)
                                    <option value="{{$key}}">{{$type['label']}}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_type') }}
                                </div>
                            </div>

                          
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_column_id') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_type') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$row->id}}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ App\Models\AchievementCategory::TYPES[$row->type]['color'] }}">{{ App\Models\AchievementCategory::TYPES[$row->type]['label'] }}</span>
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
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

@endsection

<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript">
  "use strict";
    $(document).ready(function(){
        $(".submissionType").on('change', function(e){
            var type = $(this).val();  // Use $(this) to refer to the changed element
            var count = 0; // Initialize the count
            var fields = null;
            var response = ''; // Declare response variable outside the loop

            // Define counts for different types
            if (type === 'Student') {
                fields = ["roll_no","first_name", "country","state", "city","student_id", 
                            "gender","dob","admission_no","user_category_id","seat_type_id","academic_year_from",
                            "academic_year_to","phone","email"];
                count = 7;
            } else if (type === 'Staff') {
                fields = ["first_name","staff_id","department_id","designation_id","role","phone","email",
                        "gender","dob","country",'state','city'];
                count = 10;
            }

            // Loop through fields and create badges
            fields.forEach(function(item, index) {
                response += '<span class="ml-2 badge badge-secondary" style="color:black;">' + item + '</span> ';
            });

            $('.available-variables').html(response); // Set the HTML content
        });
    });

</script>