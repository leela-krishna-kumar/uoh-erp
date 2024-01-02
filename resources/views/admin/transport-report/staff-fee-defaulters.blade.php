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
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.transport.staff-fee-defaulters') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="department">{{ __('field_department') }}</label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $departments as $department )
                                        <option value="{{ $department->id }}" @if( $selected_department == $department->id) selected @endif>{{ $department->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_department') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="designation">{{ __('field_designation') }}</label>
                                    <select class="form-control" name="designation" id="designation">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $designations as $designation )
                                        <option value="{{ $designation->id }}" @if( $selected_designation == $designation->id) selected @endif>{{ $designation->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_designation') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="category">{{ __('Category') }} <span>*</span></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach( $categories as $category )
                                        <option value="{{ $category->id }}" @if( $selected_category == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('Category') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    @if(isset($rows))                
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_staff_id') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_department') }}</th>
                                        <th>{{ __('field_designation') }}</th>
                                        <!-- <th>{{ __('Total Fee') }}</th> -->
                                        <th>{{ __('Fee') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                  @if(getStaffFeeByType($row,'Transportation',request()->category)['remaining_fee'] > 0)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>{{ $row->department->title ?? '' }}</td>
                                        <td>{{ $row->designation->title ?? '' }}</td>
                                        <!-- <td>{{ number_format((float)getStaffFeeByType($row,'Transportation',request()->category)['total_fee'], 2, '.', '') }} </td> -->
                                        <td>{{ number_format((float)getStaffFeeByType($row,'Transportation',request()->category)['remaining_fee'], 2, '.', '') }} </td>
                                        <td>
                                            <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection