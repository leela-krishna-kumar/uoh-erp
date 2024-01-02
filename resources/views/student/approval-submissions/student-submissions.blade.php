@extends('student.layouts.student-master')
@section('title', $title)
@section('content')

@section('content')

<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">     
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
    
            <div class="items-center justify-between  pb-5 sm:flex">
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold text-black"> {{ $title }}</h1> 
                </div>
                <div class="flex items-center space-x-3">
                    
                    <div class="bg-white border flex items-center overflow-hidden relative rounded-lg">
                        <i class="pl-4 -mr-2 relative uil-search"></i>
                        <input class="flex-1 max-h-9" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
            
            <div class="card-block">
                <a href="javascript:void(0)" class="btn btn-primary" uk-toggle="target: #addSubmission"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
            </div>
            @if($rows)
                <div class="card-block mt-3">
                    <!-- [ Data table ] start -->
                    <div class="table-responsive border">
                        <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Approver') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->approver->full_name }}</td>
                                        <td>{{ Str::limit(strip_tags($row->note), 50, '...') }}</td>
                                        <td>
                                            @if( $row->status == 1 )
                                                <span class="badge badge-pill badge-success">{{ __('status_approved') }}</span>
                                            @elseif( $row->status == 2 )
                                                <span class="badge badge-pill badge-danger">{{ __('status_rejected') }}</span>
                                            @else
                                                <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ @$row->category->name }}</span>
                                        </td>
                                        <td>
                                            @if($row->status == 0)
                                                {{-- <a href="javascript:void(0)" uk-toggle="target: #editSubmission-{{ $row->id }}" class="btn btn-icon btn-info btn-sm"><i class="fas fa-edit"></i></a> --}}
                                            @endif
                                            @include('student.approval-submissions.include.edit')
                                            @if($row->link != null)
                                            <a href="{{ $row->link }}" target="_blank" class="btn btn-icon btn-dark btn-sm"><i class="fas fa-download"></i></a>
                                            @endif
                                            @if($row->status == 0)
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" uk-toggle="target: #studentDeleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('student.inc.delete')
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->
                </div>
            @else
                @include('student.layouts.no-data')
            @endif
        </div>

        @include('student.layouts.footer.student-footer')
        
    </div>
    <!-- Main Contents -->
    
@include('student.approval-submissions.include.add')
@endsection
<!-- End Content-->

@endsection