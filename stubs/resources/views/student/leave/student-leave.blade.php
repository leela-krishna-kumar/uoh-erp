@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
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
                <a href="javascript:void(0)" uk-toggle="target: #addLeave" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>

                <a href="{{route('student.student-apply-leave')}}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
            </div>
            @if($rows->count() > 0)
            <div class="card-block mt-3">
                <!-- [ Data table ] start -->
                <div class="table-responsive border">
                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('field_leave_subject') }}</th>
                                <th>{{ __('field_leave_date') }}</th>
                                <th>{{ __('field_days') }}</th>
                                <th>{{ __('field_apply_date') }}</th>
                                <th>{{ __('field_status') }}</th>
                                <th>{{ __('field_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $rows as $key => $row )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{!! str_limit(strip_tags($row->subject), 50, ' ...') !!}</td>
                                    <td>
                                        @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->from_date)) }}
                                        @else
                                            {{ date("Y-m-d", strtotime($row->from_date)) }}
                                        @endif
                                        -
                                        @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->to_date)) }}
                                        @else
                                            {{ date("Y-m-d", strtotime($row->to_date)) }}
                                        @endif
                                    </td>
                                    <td>{{ (int)((strtotime($row->to_date) - strtotime($row->from_date))/86400) + 1 }}</td>
                                    <td>
                                        @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->apply_date)) }}
                                        @else
                                            {{ date("Y-m-d", strtotime($row->apply_date)) }}
                                        @endif
                                    </td>
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
                                        <button type="button" class="btn btn-icon btn-success btn-sm" uk-toggle="target: #showLeave-{{ $row->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <!-- Include Show modal -->
                                        @include('student.leave.include.show')

                                        @if(is_file('uploads/'.$path.'/'.$row->attach))
                                        <a href="{{ asset('uploads/'.$path.'/'.$row->attach) }}" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
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
    
    @include('student.leave.include.add')
    @endsection
    {{-- <div id="dialog" title="Dialog Title">
        <p>test</p>
    </div> --}}
<!-- End Content-->
 
@push('script')
<script>
     
</script>
@endpush
    

