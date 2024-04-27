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
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createseed_grant-{{ Auth::user()->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                    @endcan
                        <a href="{{ url('admin/faculty-achievements/seed_grants') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>


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
                                        <th>Application Number</th>
                                        <th>Title</th>
                                        {{-- <th>Department</th> --}}
                                        <th>PIs</th>
                                        <th>Co PIs</th>
                                        <th>Duration in Months</th>
                                        <th>Scope</th>
                                        <th>Research Area</th>
                                        <th>Amount in Rupees</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($seed_grants as $key => $seed_grant)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ @$seed_grant->application_no }}</td>
                                         <td>{{ @$seed_grant->title }}</td>

                                        @php
                                            $pis = json_decode($seed_grant->pi);
                                        @endphp

                                    <td>
                                        @foreach ($pis as $pi)
                                            {{ $pi }},
                                        @endforeach
                                    </td>

                                    @php
                                            $co_pis = json_decode($seed_grant->co_pi);
                                        @endphp

                                    <td>
                                        @foreach ($co_pis as $pi)
                                            {{ $pi }},
                                        @endforeach
                                    </td>

                                    {{--
                                    @php
                                        $department = App\Models\Department::find(Auth::user()->department_id);
                                    @endphp
                                        <td>{{ @$department->title }}</td>
                                        --}}
                                        <td>{{ @$seed_grant->duration_in_months }}</td>
                                        <td>{{ @$seed_grant->scope }}</td>
                                        <td>{{ @$seed_grant->research_area }}</td>
                                        <td>{{ @$seed_grant->amount_in_rupees }}</td>
                                        {{-- <td>
                                        <a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$seed_grant->paper_abstract_article_link }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        </td> --}}

                                        <td>


                                        @can($access.'-action')

                                            @can($access.'-edit')

                                                @if($seed_grant->staff_id == auth()->user()->staff_id)
                                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editseed_grant-{{ $seed_grant->id }}">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                                @include('admin.faculty_achievements.seed_grants.edit')
                                                @else
                                                {{-- @can($access.'-edit')
                                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editseed_grant-{{ $seed_grant->id }}">
                                                    <i class="far fa-edit"></i>
                                                </button>

                                                @include('admin.faculty_achievements.seed_grants.edit')
                                                @endcan --}}
                                                @endif

                                            @endcan

                                            @can($access.'-delete')

                                                @if($seed_grant->staff_id == auth()->user()->staff_id)
                                                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteseedgrant-{{ $seed_grant->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                @include('admin.faculty_achievements.seed_grants.delete')
                                                @else
                                                {{-- @can($access.'-delete')
                                                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteseedgrant-{{ $seed_grant->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                @include('admin.faculty_achievements.seed_grants.delete')
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

@include('admin.faculty_achievements.seed_grants.create')


@endsection
@section('page_js')

@yield('sub-script')

@endsection
