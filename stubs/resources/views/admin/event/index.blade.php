@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter By</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="start_date" class="form-label">Select Start Date <span>*</span></label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                                </div>
    
                                <div class="form-group col-md-3">
                                    <label for="last_date" class="form-label">Select Last Date <span>*</span></label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] start -->
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
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role_id" class="form-label">{{ __('field_role') }} <span>*</span></label>
                                <select class="form-control select2" name="role_id" id="role_id" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach($roles as $key => $role)
                                        @if($key === $roles->keys()->last())
                                            <option value="0">{{ __('field_student') }}</option>
                                        @endif
                                        <option value="{{ $role->id }}" @if(old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_role') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category_id">{{ __('field_category') }} <span>*</span></label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $event_categories as $category )
                                    <option value="{{ $category->id }}">{{ $category->name}}</option>
                                    @endforeach
                                </select>
    
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_category') }}
                                </div>
                            </div>
    

                            <div class="form-group">
                                <label for="start_date" class="form-label">{{ __('field_start_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_start_date') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="form-label">{{ __('field_end_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ old('end_date') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_end_date') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="color" class="form-label">{{ __('field_color') }} <span>*</span></label>
                                <input type="text" class="form-control color_picker" name="color" id="color" value="#70c24a" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_color') }}
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
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_role') }}</th>
                                        <th>{{ __('field_category') }}</th>
                                        <th>{{ __('field_start_date') }}</th>
                                        <th>{{ __('field_end_date') }}</th>
                                        <th>{{ __('field_color') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                  @php
                                      $rolesIds = json_decode($row['role_id']);
                                  @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{$row->role ? $row->role->name : '--'}}</td>

                                        <td>{{@$row->category->name}}</td>
                                        <td>
                                            @if(isset($setting->date_format))
                                            {{date($setting->date_format, strtotime($row->start_date))}}
                                            @else
                                            {{ date("Y-m-d", strtotime($row->start_date)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->end_date)) }}
                                            @else
                                            {{ date("Y-m-d", strtotime($row->end_date)) }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge" style="background: {{ $row->color }}; width: 60px; height: 15px;">  </span>
                                        </td>
                                        <td>
                                            @if($row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>


                                            <a href="{{ route($route.'-user.create',['event_id' =>$row->id]) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-user"></i>
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