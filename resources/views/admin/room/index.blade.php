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
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <!-- Add modal button -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                        <!-- Include Add modal -->
                        @include($view.'.create')
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_room') }}</th>
                                        <th>{{ __('field_floor') }}</th>
                                        <th>{{ __('field_capacity') }}</th>
                                        <th>{{ __('field_type') }}</th>
                                        <th>{{ __('Lights') }}</th> 
                                        <th>{{ __('Fans') }}</th> 
                                        <th>{{ __('Benches') }}</th> 
                                        <th>{{ __('Projecters') }}</th> 
                                        <th>{{ __('Size') }}</th> 
                                        <th>{{ __('Smart') }}</th> 
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->floor }}</td>
                                        <td>{{ $row->capacity }}</td>
                                        <td>
                                            @if( $row->type == 1 )
                                            {{ __('Class Room') }}
                                            @elseif($row->type == 2)
                                            {{ __('Lab') }}
                                            @else
                                            {{ $row->type }}
                                            @endif
                                        </td>
                                        <td>{{ $row->light }}</td>
                                        <td>{{ $row->fan }}</td>
                                        <td>{{ $row->bench }}</td>
                                        <td>{{ $row->projecter }}</td>
                                        <td>{{ $row->size }}</td>
                                        <td>
                                            @if( $row->smart_room == 1 )
                                            {{ __('Yes') }}
                                            @elseif($row->smart_room == 2)
                                            {{ __('No') }}
                                            @else
                                            {{ $row->smart_room }}
                                            @endif
                                        </td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
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
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection