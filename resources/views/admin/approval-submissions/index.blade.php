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
                                        <th>{{ __('Name') }}</th>
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
                                            @if ($row->role_id != 0)
                                                {{@$row->user->full_name}}
                                            @else
                                                {{@$row->student->full_name}}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ @$row->category->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ App\Models\ApprovalSubmission::STATUSES[$row->status]['color'] }}">{{ App\Models\ApprovalSubmission::STATUSES[$row->status]['label'] }}</span>
                                        </td>
                                        <td>{{$row->created_at ?? '--'}}</td>
                                      
                                        <td>
                                            @can($access.'-show')
                                            <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan

                                            <a title="View Documents" href="{{$row->link}}" target="_blank" class="btn btn-icon btn-primary btn-sm"><i class="fas fa-file"></i>
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