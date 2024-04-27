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

                         <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createpatent-{{ Auth::user()->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>

                        @endcan

                        <a href="{{ url('admin/faculty-achievements/patent') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>



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
                                        <th style=>Patent Application No</th>
                                        <th>Status Of Patent</th>
                                        {{-- <th>Department</th> --}}
                                        <th>Patent Inventor</th>
                                        <th>Title Of Patent</th>
                                        <th>Patent Applicant</th>
                                        <th>Patent Published Date</th>
                                        {{-- <th>Journal Website Link</th>
                                        <th>Paper Abstract Article Link</th> --}}
                                        <th>link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($patent as $key => $patent)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{ @$patent->staff_id }}</td> --}}
                                        <td>{{ @$patent->patent_application_no }}</td>
{{--
                                        @php
                                            $status_of_patent = json_decode($patent->status_of_patent);
                                        @endphp --}}

                                    {{-- <td>
                                        @foreach ($status_of_patent as $patent)
                                            {{ $patent }},
                                        @endforeach
                                    </td> --}}

                                    {{-- @php
                                        $department = App\Models\Department::find(Auth::user()->department_id);
                                    @endphp
                                        <td>{{ @$department->title }}</td> --}}
                                        <td>{{ @$patent->status_of_patent }}</td>
                                        <td>{{ @$patent->patent_inventor }}</td>
                                        <td>{{ @$patent->title_of_patent }}</td>
                                        <td>{{ @$patent->patent_applicant }}</td>
                                        <td>{{ @$patent->patent_published_date }}</td>

                                        <td><a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$patent->link }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- <a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$journal->paper_abstract_article_link }}">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}
                                        </td>

                                        <td>
                                            @can($access.'-action')
                                                @can($access.'-edit')
                                                    @if($patent->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editpatent-{{ $patent->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        @include('admin.faculty_achievements.patent.edit')
                                                    @else
                                                        {{-- @can($access.'-edit')
                                                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editpatent-{{ $patent->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        @include('admin.faculty_achievements.patent.edit')

                                                        @endcan --}}
                                                    @endif
                                                @endcan

                                                @can($access.'-delete')
                                                    @if($patent->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletepatent-{{ $patent->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.patent.delete')

                                                    @else
                                                        {{-- @can($access.'-delete')
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletepatent-{{ $patent->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.patent.delete')
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

@include('admin.faculty_achievements.patent.create')


@endsection
@section('page_js')

@yield('sub-script')

@endsection
