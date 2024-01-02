@extends('admin.layouts.master')
@section('title', $title)
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
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.create') }}">
                            <div class="row gx-2">
                                @include('common.inc.staff_search_filter')
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @if(isset($rows))
                @if(count($rows) > 0)
                    <div class="col-sm-12">
                        <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-block">
                                    <input type="hidden" name="department" value="{{ $selected_department }}" hidden>
                                    <input type="hidden" name="designation" value="{{ $selected_designation }}" hidden>
                                    <input type="hidden" name="role" value="{{ $selected_role }}" hidden>
                                    <input type="hidden" name="selected_contract" value="{{ $selected_contract }}" hidden>
                                    <input type="hidden" name="selected_shift" value="{{ $selected_shift }}" hidden>
                                    <input type="hidden" name="staff_ids" class="staff_ids"value="">
                                    <input type="hidden" name="status"value="{{App\Models\Task::STATUS_PENDING}}">
                                    <span class="mb-2 mt-0"><label for=""class="text-danger">*</label>Choose Staff who is submitting Task</span>
                                    <div class="table-responsive">
                                        <table class="display table nowrap table-striped table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="checkbox checkbox-success d-inline">
                                                          <input type="checkbox" id="checkbox" class="all_select">
                                                            <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                                        </div>
                                                      </th>
                                                    <th>{{ __('field_staff_id') }}</th>
                                                    <th>{{ __('field_name') }}</th>
                                                    <th>{{ __('field_department') }}</th>
                                                    <th>{{ __('field_designation') }}</th>
                                                    <th>{{ __('field_role') }}</th>
                                                    <th>{{ __('field_salary_type') }}</th>
                                                    <th>{{ __('field_status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach( $rows as $key => $row )
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-primary d-inline">
                                                            <input type="checkbox" name="staff_ids[]" id="checkbox-{{ $row->id }}" value="{{ $row->id }}"  @if (in_array($row->id, (array) old('student_id', []))) checked @endif>
                                                            <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route($route.'.show', $row->id) }}">
                                                            #{{ $row->staff_id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                                    <td>{{ $row->department->title ?? '' }}</td>
                                                    <td>{{ $row->designation->title ?? '' }}</td>
                                                    <td>@foreach($row->roles as $role) {{ $role->name ?? '' }} @endforeach</td>
                                                    <td>
                                                        @if( $row->salary_type == 1 )
                                                        {{ __('salary_type_fixed') }}
                                                        @elseif( $row->salary_type == 2 )
                                                        {{ __('salary_type_hourly') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if( $row->status == 1 )
                                                        <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                                        @else
                                                        <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                              @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group col-md-12">
                                                    <label for="task">Task</label>
                                                    <textarea type="text" class="form-control" name="task" id="task" rows="3" required></textarea>
                                                    <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('field_task') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group col-md-12">
                                                    <label for="task">Deadline</label>
                                                    <input type="datetime-local" class="form-control" name="deadline_at" id="deadline_at" value="" >
                                                    <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('field_task') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success saveBtn"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="text-center">
                                <h6>No Record Found..</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
             
        
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->
@endsection
@section('page_js')

@yield('sub-script')
<script>
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
</script>
@endsection