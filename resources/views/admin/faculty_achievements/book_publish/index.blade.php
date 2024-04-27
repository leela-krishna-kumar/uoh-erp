@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
    td {
    max-width: 200px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
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
                            <a href="{{ url('admin/faculty-achievements/books-published/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title of Book</th>
                                        <th>Name of the author/s</th>
                                        <th>Year of Publication</th>
                                        <th>Publisher Name</th>
                                        <th>ISBN Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book_publishions as $key => $publishion)
                                      <tr>
                                          <td>{{ $key + 1 }}</td>
                                          <td>{{ @$publishion->published_book_title }}</td>

                                          @php
                                          $user = App\User::where('staff_id', $publishion->staff_id)->first();
                                            if($user)
                                            {
                                                $name = $user->first_name . ' ' . $user->last_name;
                                            }else {
                                                $name = '';
                                            }
                                          @endphp
                                          <td>{{ $name }}</td>
                                          <td>{{ @$publishion->publication_year }}</td>
                                          <td>{{ @$publishion->publisher_name }}</td>
                                          <td>{{ @$publishion->isbn_number }}</td>
                                          <td>

                                            @can($access.'-action')

                                            <a type="button" href="{{ route($route.'.show', $publishion->id) }}" class="btn btn-icon btn-primary btn-sm" href=" {{ @$publishion->link }}">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @can($access.'-edit')
                                            @if($publishion->staff_id == auth()->user()->staff_id)
                                                <a href="{{ route($route.'.edit', $publishion->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            @else
                                                {{-- @can($access.'-edit')
                                                    <a href="{{ route($route.'.edit', $publishion->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                @endcan --}}
                                            @endif
                                            @endcan

                                            @can($access.'-delete')
                                            @if($publishion->staff_id == auth()->user()->staff_id)
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletebookpublish-{{ $publishion->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                             @include('admin.faculty_achievements.book_publish.delete')
                                            @else
                                                {{-- @can($access.'-delete')

                                                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletebookpublish-{{ $publishion->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                 @include('admin.faculty_achievements.book_publish.delete')
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
