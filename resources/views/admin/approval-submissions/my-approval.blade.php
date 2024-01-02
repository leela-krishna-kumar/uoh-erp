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
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            @if (auth()->user()->roles[0]->name != 'Super Admin')
                                <a href="{{ route($route.'.index') }}" class="btn @if (request()->segment(2) == 'approval-submissions')  btn-info @else btn-outline-info @endif">Student Approvals</a>
                                <a href="{{ route('admin.my-approval-submissions') }}" class="btn @if (request()->segment(2) == 'my-approval-submissions')  btn-info @else btn-outline-info @endif">My Approvals</a>
                            @else
                                <h5>{{ $title }}</h5>
                            @endif
                        </div>
                            <div>
                                @if (auth()->user()->roles[0]->name != 'Super Admin')
                                    <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                                @endif
                                <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                            </div>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{__('ID')}}</th>
                                        <th>{{ __(' Category') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Created At') }}</th>                                
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ @$row->category->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ App\Models\ApprovalSubmission::STATUSES[$row->status]['color'] }}">{{ App\Models\ApprovalSubmission::STATUSES[$row->status]['label'] }}</span>
                                        </td>
                                        <td>{{$row->created_at ?? '--'}}</td>
                                      
                                        <td>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')

                                            <a title="View Documents" href="{{$row->link}}" target="_blank" class="btn btn-icon btn-primary btn-sm">
                                                <i class="fas fa-file"></i>
                                            </a>
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