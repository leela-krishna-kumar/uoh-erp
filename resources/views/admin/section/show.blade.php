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
                            <h5>{{ $section->title }} {{ __('list') }}</h5>


                            <div class="card-block">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_program') }} </th>
                                                <th>{{ __('field_semester') }}</th>
                                                <th>{{ __('field_teacher') }}</th>
                                                <th>{{ __('field_action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($rows as $key => $row)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>
                                                        <span
                                                            class="badge badge-primary">{{ $row->program->title ?? '' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">
                                                            {{ $row->semester->title ?? '' }}</span>
                                                    </td>
                                                    <td>{{ @$row->teacher->full_name ?? '--' }}</td>
                                                    {{-- <td>

                                                        @can($access . '-show')
                                                            <button class="btn btn-sm btn-icon btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#addModal-{{ $row->id }}"><i
                                                                    class="fas fa-plus"></i></button>
                                                            @include('admin.section.assign-teacher')
                                                        @endcan

                                                        @can($access . '-delete')
                                                            <button type="button" class="btn btn-icon btn-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal-{{ $row->id }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                            <!-- Include Delete modal -->
                                                            @include('admin.layouts.inc.delete')
                                                        @endcan

                                                    </td> --}}

                                                    <td>
                                                      @can($access.'-create')
                                                    
                                                      @if($row->teacher_id !== null)
                                                          <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#addModal-{{ $row->id }}"><i class="fas fa-times"></i></button>
                                                          @include('admin.section.assign-teacher')
                                                      @else
                                                          <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#addModal-{{ $row->id }}"><i class="fas fa-plus"></i></button>
                                                          @include('admin.section.assign-teacher')
                                                      @endif
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

    @section('page_js')
        <script type="text/javascript">
            "use strict";
            // checkbox all-check-button selector
            $(".all_check").on('click', function(e) {
                if ($(this).is(":checked")) {
                    // check all checkbox
                    $(".semester").prop('checked', true);
                } else if ($(this).is(":not(:checked)")) {
                    // uncheck all checkbox
                    $(".semester").prop('checked', false);
                }
            });
        </script>
    @endsection
