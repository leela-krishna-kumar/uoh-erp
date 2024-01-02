@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter By</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="date">{{ __('field_date') }} <span>*</span></label>
                                    <input type="date" class="form-control" name="date" value="{{request()->get('date')}}">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_date') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="status">{{ __('field_company') }} <span>*</span></label>
                                <select class="form-control select2" name="company_id" id="company_id" required>
                                    <option value="">{{ __('Select Company') }}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" @if(old('company_id') == $company->id) selected @endif>{{ $company->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_company') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date" class="form-label">Date of Visit <span>*</span></label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_date') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('field_description') }}</label>
                                <textarea type="text" class="form-control" name="description" id="description"rows="5" value="{{ old('description') }}"></textarea>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_description') }}
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5>{{$title}} {{ __('list') }}</h5>
                        </div>
                        <div>
                            <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                        </div>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_company') }}</th>
                                        <th title="Date of visit">DOV</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ @$row->company->name }}</td>
                                        <td>{{ $row->date }}</td>
                                        <td>

                                            <a title="Placed Students" href="{{ route('admin.placed-student.index',['placement_id' => $row->id]) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-users"></i>
                                            </a>
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
                                            <button type="button" class="btn btn-icon btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#showplacement-{{$row->id}}">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            @include('admin.placement.show-modal')
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