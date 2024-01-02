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
                                        <label for="book">{{trans_choice('module_accordion_book',1) }}</label>
                                        <select class="form-control select2" name="book_id" id="book_id">
                                            <option value="">{{ __('select') }}</option>
                                            @foreach( $books as $book )
                                            <option value="{{ $book->id }}" @if (request()->get('book_id') == $book->id) selected @endif> {{ $book->title }}</option>
                                            @endforeach
                                        </select>

                                            <div class="invalid-feedback">
                                                {{ __('required_field') }} {{trans_choice('module_accordion_book',1) }}
                                            </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="member">{{trans_choice('module_accordion_department',1) }}</label>
                                        <select class="form-control select2" name="department_id" id="department_id">
                                            <option value="">{{ __('select') }}</option>
                                            @foreach( $depatments as $depatment )
                                            <option value="{{ $depatment->id }}" @if (request()->get('department_id') == $depatment->id) selected @endif> {{ $depatment->title }}</option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                             {{ __('required_field') }} {{ __('module_accordion_department') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="member">{{trans_choice('module_accordion_status',1) }}</label>
                                        <select class="form-control select2" name="status" id="status">
                                            <option value="">{{ __('select') }}</option>
                                            @foreach( $statuses as $key => $status )
                                            <option value="{{ $key }}" @if (request()->has('status') && request()->get('status') == $key) selected @endif> {{ $status['label'] }}</option>
                                            @endforeach
                                        </select>
                                           <div class="invalid-feedback">
                                                {{ __('required_field') }} {{trans_choice('module_accordion_status',1) }}
                                            </div>
                                    </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card ">
                        <div class="card-block">
                            <!-- [ Data table ] start -->
                            <div class="table-responsive">
                                <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{trans_choice('module_accordion_book',1) }}</th>
                                            <th>{{trans_choice('module_accordion_department',1) }}</th>
                                            <th>{{trans_choice('module_accession_no',1) }}</th>
                                            <th>{{trans_choice('module_accordion_status',1) }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('field_action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rows as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ @$row->book->title ?? '--' }}</td>
                                            <td>{{ @$row->department->title ?? '--' }}</td>
                                            <td>{{ @$row->accordion_no ?? '--' }}</td>
                                            <td>{{ @\App\Models\BookAccordion::STATUSES[$row->status]['label']}}</td>
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
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection