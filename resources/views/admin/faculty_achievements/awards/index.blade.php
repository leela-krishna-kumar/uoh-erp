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
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createawards-{{ Auth::user()->id }}" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ url('admin/faculty-achievements/awards') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>


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
                                        <th>Faculty Name</th>
                                        <th>Award Name</th>
                                        <th>Awarding Agency</th>
                                        <th>Date</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                        {{-- <th>Journal Website Link</th>
                                        <th>Paper Abstract Article Link</th> --}}

                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($awards as $key => $awards)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        @php
                                        $user = App\User::where('staff_id', $awards->staff_id)->first();
                                          if($user)
                                          {
                                              $name = $user->first_name . ' ' . $user->last_name;
                                          }else {
                                              $name = '';
                                          }
                                        @endphp
                                        <td>{{ @$name }}</td>
                                        <td>{{ @$awards->award_name }}</td>
                                        <td>{{ @$awards->awarding_agency }}</td>
                                        <td>{{ @$awards->date }}</td>
                                        {{-- <td>{{ @$awards->image }}</td> --}}

                                        {{-- <td><a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$patent->link }}">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}

                                        {{-- <a type="button" class="btn btn-icon btn-primary btn-sm" href=" {{ @$journal->paper_abstract_article_link }}">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#imageaward-{{ @$awards->id }}">
                                                <i class="fas fa-eye"></i>
                                             </button>

                                             @include('admin.faculty_achievements.awards.image')
                                          </td>

                                        <td>
                                            @can($access.'-action')
                                                @can($access.'-edit')
                                                    @if($awards->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editawards-{{ $awards->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        @include('admin.faculty_achievements.awards.edit')

                                                    @else
                                                        {{-- @can($access.'-edit')
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#editawards-{{ $awards->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        @include('admin.faculty_achievements.awards.edit')

                                                        @endcan --}}

                                                    @endif
                                                @endcan

                                                @can($access.'-delete')

                                                    @if($awards->staff_id == auth()->user()->staff_id)
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteaward-{{ $awards->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.awards.delete')
                                                    @else
                                                        {{-- @can($access.'-delete')
                                                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteaward-{{ $awards->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        @include('admin.faculty_achievements.awards.delete')
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

@include('admin.faculty_achievements.awards.create')


@endsection
@section('page_js')

@yield('sub-script')

@endsection
