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
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createjournal-{{ Auth::user()->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ url('admin/faculty-achievements/journals') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>


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
                                        <th style=>Title of paper</th>
                                        <th>Name of the author/s</th>
                                        {{-- <th>Department</th> --}}
                                        <th>Name of the journal</th>
                                        <th>Year of publication</th>
                                        <th>ISSN Number</th>
                                        <th>Link/s</th>
                                        {{-- <th>Journal Website Link</th>
                                        <th>Paper Abstract Article Link</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($journals as $key => $journal)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ @$journal->title_of_paper }}</td>

                                        @php
                                            $name_of_the_author = json_decode($journal->name_of_the_author);
                                        @endphp

                                    <td>
                                        @foreach ($name_of_the_author as $author)
                                            {{ $author }}
                                        @endforeach
                                    </td>

                                    {{-- @php
                                        $department = App\Models\Department::find(Auth::user()->department_id);
                                    @endphp
                                        <td>{{ @$department->title }}</td> --}}
                                        <td>{{ @$journal->name_of_the_journal }}</td>
                                        <td>{{ @$journal->year_of_publication }}</td>
                                        <td>{{ @$journal->issn_number }}</td>
                                        <td><a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$journal->journal_website_link }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$journal->paper_abstract_article_link }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        </td>

                                        <td>
                                            @can($access.'-action')

                                                @can($access.'-edit')

                                                    @if($journal->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editjournal-{{ $journal->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        @include('admin.faculty_achievements.journals.edit')
                                                    @else
                                                        {{-- @can($access.'-edit')
                                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editjournal-{{ $journal->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        @include('admin.faculty_achievements.journals.edit')
                                                        @endcan --}}
                                                    @endif
                                                @endcan

                                                @can($access.'-delete')
                                                    @if($journal->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletejournal-{{ $journal->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.journals.delete')
                                                    @else
                                                        {{-- @can($access.'-delete')
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletejournal-{{ $journal->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.journals.delete')
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

@include('admin.faculty_achievements.journals.create')


@endsection
@section('page_js')

@yield('sub-script')

@endsection
