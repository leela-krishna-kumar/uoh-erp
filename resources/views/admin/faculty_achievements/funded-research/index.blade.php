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

                        @can($access.'-create')
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createFundedResearch-{{ Auth::user()->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ url('admin/faculty-achievements/funded-research') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
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
                                        <th>PI / Co PI</th>
                                        <th>Funding agency</th>
                                        <th>Sponsored Project</th>
                                        <th>Funds provided</th>
                                        <th>Grant Received on</th>
                                        <th>Duration of the project</th>
                                        <th>Type </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($funded_research as $key => $research)
                                    <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ @$research->pi_or_co_pi }}</td>
                                    <td>{{ @$research->funding_agency }}</td>
                                    <td>{{ @$research->sponsored_project }}</td>
                                    <td>{{ @$research->funds_provided }}</td>
                                    <td>{{ @$research->grant_month_and_year }}</td>
                                    <td>{{ @$research->project_duration }}</td>
                                    <td>{{ @$research->type }}</td>
                                    <td>{{ @$research->status }}</td>
                                        <td>

                                            @can($access.'-action')

                                            @can($access.'-edit')

                                            @if($research->staff_id == auth()->user()->staff_id)
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editFundedResearch-{{ $research->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>

                                             @include('admin.faculty_achievements.funded-research.edit')
                                            @else
                                            {{-- @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editFundedResearch-{{ $research->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>

                                             @include('admin.faculty_achievements.funded-research.edit')

                                            @endcan --}}
                                            @endif

                                            @endcan

                                            @can($access.'-delete')

                                            @if($research->staff_id == auth()->user()->staff_id)
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFundedResearch-{{ $research->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                             @include('admin.faculty_achievements.funded-research.delete')
                                            @else
                                            {{-- @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFundedResearch-{{ $research->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                             @include('admin.faculty_achievements.funded-research.delete')

                                            @endcan --}}
                                            @endif

                                            @endcan

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

@include('admin.faculty_achievements.funded-research.create')


@endsection
@section('page_js')

@yield('sub-script')

@endsection
