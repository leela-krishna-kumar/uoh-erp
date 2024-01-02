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
                        <h5>{{ $title }} </h5>
                    </div>
                    {{-- @dd(can($access.'-create')); --}}
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                @include('common.inc.student_search_filter')

                                <div class="form-group col-md-3">
                                    <label for="status">{{ __('field_category') }}</label>
                                    <select class="form-control" name="project_category_id" id="project_category_id">
                                        <option value="">{{ __('Select Category') }}</option>
                                        @foreach($project_categories as $category)
                                            <option value="{{ $category->id }}" @if(old('project_category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_status') }}
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

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>
                                            {{ __('field_faculty') }}
                                            <div class="hr-1"></div>
                                            {{ __('field_program') }}
                                        </th>
                                        <th>{{ __('field_subject') }}</th>
                                        <th>{{ __('field_category') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_tags') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ @$row->student->first_name }} {{@$row->student->last_name}}</td>
                                        <td>{{ Str::limit($row->title,30) }}</td>
                                        <td>
                                            {{ @$row->student->faculty->title }}
                                            <div class="hr-1"></div>
                                            {{ @$row->student->program->title }}
                                        </td>
                                        <td>{{ $row->subject->title ?? '' }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ @$row->category->name }}</span>
                                        </td>
                                        <td>{{ App\Models\Project::STATUSES[$row->status]['label'] }}</td>
                                        
                                        <td>{{ Str::limit($row->tags,30) }}</td>
                                        <td>

                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
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
@section('page_js')

@yield('sub-script')

@endsection