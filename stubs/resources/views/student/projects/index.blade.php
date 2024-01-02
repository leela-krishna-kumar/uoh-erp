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
                <a href="javascript:void(0)" class="btn btn-primary" uk-toggle="target: #addProject"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
            </div>
            @if($rows->count() > 0)
            <div class="card-block mt-3">
                <!-- [ Data table ] start -->
                <div class="table-responsive border">
                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $rows as $key => $row )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->category->name }}</td>
                                    <td>
                                        @if( $row->status == 0)
                                            <span class="badge badge-pill badge-primary">{{ __('Assigned') }}</span>
                                        @elseif( $row->status == 1)
                                            <span class="badge badge-pill badge-secondary">{{ __('Draft') }}</span>
                                        @elseif( $row->status == 2 )
                                            <span class="badge badge-pill badge-info">{{ __('In Review') }}</span>
                                        @elseif( $row->status == 3 )
                                            <span class="badge badge-pill badge-danger">{{ __('Rejected') }}</span>
                                        @else
                                            <span class="badge badge-pill badge-success">{{ __('Review') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->status == 1)
                                            <a href="javascript:void(0)" uk-toggle="target: #editProject-{{ $row->id }}" class="btn btn-icon btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                            <a href="javascript:void(0)" uk-toggle="target: #showProject-{{ $row->id }}" class="btn btn-icon btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" uk-toggle="target: #studentDeleteModal-{{ $row->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Include Delete modal -->
                                        @include('student.projects.edit')
                                        @include('student.projects.show')
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
    @include('student.projects.create')
@endsection
<!-- End Content-->

@endsection