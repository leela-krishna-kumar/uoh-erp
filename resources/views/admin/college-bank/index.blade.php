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
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
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
                                        <th>{{__('ID')}}</th>
                                        <th>{{ __('Bank Name') }}</th>
                                        <th>{{ __('Bank Holder Name') }}</th>
                                        <th>{{ __('IFSC') }}</th>
                                        <th>{{ __('Account Number') }}</th>
                                        <th>{{ __('Branch') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Created At') }}</th>                                
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ @$row->bank->name }}</td>
                                        <td>{{ @$row->account_holder_name }}</td>
                                        <td>{{ @$row->ifsc }}</td>
                                        <td>{{ @$row->account_no }}</td>
                                        <td>{{ @$row->branch }}</td>
                                        <td>
                                            @if ($row->type == 0)
                                                <span>Current</span>
                                           @elseif($row->type == 1)
                                                <span>Saving</span> 
                                            @endif
                                        </td>
                                        <td>{{$row->created_at ?? '--'}}</td>
                                      
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