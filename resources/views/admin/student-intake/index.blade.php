@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
    td {
        max-width: 200px; /* Set a maximum width for the cell */
        overflow: hidden; /* Hide the overflow content */
        white-space: nowrap; /* Prevent line breaks within the content */
        text-overflow: ellipsis; /* Display an ellipsis (...) when the text overflows */
    }
</style>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} </h5>
                    </div>
                    {{-- @dd(can($access.'-create')); --}}
                    <div class="card-block">
                        <a href="{{ url('admin/student-intake/create') }}" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        <a href="{{ url('admin/student-intake') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Faculty</th>
                                        <th>Batch</th>
                                        <th>Program</th>
                                        <th>Academic Year</th>
                                        <th>Intake Count</th>
                                        <th>Admitted Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <?php $faculty = DB::table('faculties')->where('id', $row->faculty)->first(); ?>
                                        <td>{{ $faculty->title }}</td>
                                        <?php $batch = DB::table('batches')->where('id', $row->batch)->first(); ?>
                                        <td>{{ $batch->title }}</td>
                                        <?php $program = DB::table('programs')->where('id', $row->program)->first(); ?>
                                        <td>{{ $program->title }}</td>
                                        <?php $session = DB::table('sessions')->where('id', $row->session)->first(); ?>
                                        <td>{{ $session->title }}</td>
                                        <td>{{ $row->intake_count }}</td>
                                        <td>{{ $row->admitted_count }}</td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editstudentintake-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            @include('admin.student-intake.edit')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletestudentintake-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @include('admin.student-intake.delete')
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
@section('page_js')

@yield('sub-script')

@endsection
