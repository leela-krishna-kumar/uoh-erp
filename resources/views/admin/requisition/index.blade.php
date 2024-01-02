@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
           
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>

                    <div class="card-block">
                        <div class="d-flex justify-content-between">
                            <div>
                                @can($access.'-create')
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                                @endcan

                                <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="">
                            <div class="row gx-2">

                                <div class="form-group col-md-3">
                                    <label for="status">{{ trans_choice('module_accordion_status',1) }}</label>
                                    <select class="form-control select2" name="status" id="status" required>
                                        <option value="">{{__('Select')}}</option>
                                        @foreach( $statuses as $key => $status )
                                        <option value="{{ $key }}" @if (request()->has('status') && request()->get('status') == $key) selected @endif>{{ $status['label'] }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ trans_choice('module_accordion_status',1) }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <!-- Add this code above the table -->
                        <div class="table-responsive">
                     
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans_choice('module_requisition_book_name',1) }}</th>
                                        <th>{{trans_choice('module_requisition_author_name',1) }}</th>
                                         <th>{{ __('status')}}</th>
                                         <th>{{trans_choice('module_requisition_remark',1) }}</th>
                                        
                                         <th>{{ __('Created At') }}</th>
                                         
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ @$row->book_name ?? '--' }}</td>
                                        <td>{{ @$row->author_name?? '--' }}</td>
                                        <td>{{ \App\Models\Requisition::STATUSES[$row->status]['label'] }}</td>
                                        <td>{{ @$row->remark ?? '--' }}</td>
                                        <td>{{ @$row->created_at ?? '--' }}</td>
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
@push('scripts')
<!-- Add this script at the end of your Blade view -->
<!-- Add this script at the end of your Blade view -->
<script src="path/to/jquery.min.js"></script>
<script src="path/to/autoNumeric.js"></script>

<script>
    $(document).ready(function () {
        // Assuming you have jQuery and the select2 plugin initialized

        // Change event handler for the status select
        $('#status').on('change', function () {
            var selectedStatus = $(this).val();
            alert(selectedStatus);

            // Make an AJAX request to fetch filtered data
            $.ajax({
                url: "{{ url('/admin/requisitions/filter') }}/" + selectedStatus,
                type: 'GET',
                success: function (response) {
                    // Update the table with filtered data
                    updateTable(response.data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Function to update the table with filtered data
        function updateTable(data) {
            // Clear existing table rows
            $('#export-table tbody').empty();

            // Add new rows based on filtered data
            $.each(data, function (key, row) {
                var newRow = '<tr>' +
                    '<td>' + (key + 1) + '</td>' +
                    '<td>' + (row.book_name || '--') + '</td>' +
                    '<td>' + (row.author_name || '--') + '</td>' +
                    '<td>' + row.status.label + '</td>' +
                    '<td>' + (row.remark || '--') + '</td>' +
                    '<td>' + (row.created_at || '--') + '</td>' +
                    '<td>' +
                    // Add your action buttons here
                    '</td>' +
                    '</tr>';

                $('#export-table tbody').append(newRow);
            });
        }
    });
</script>

@endpush


@endsection