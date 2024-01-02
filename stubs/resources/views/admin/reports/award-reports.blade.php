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
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Color') }}</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('End Date') }}</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{@$row->title }}</td>
                                        <td>{{@$row->role ? $row->role->name : '--'}}</td>
                                        <td>{{@$row->category->name }}</td>
                                        <td>
                                            @if($row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge" style="background: {{ $row->color }}; width: 60px; height: 15px;">  </span>
                                        </td>
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