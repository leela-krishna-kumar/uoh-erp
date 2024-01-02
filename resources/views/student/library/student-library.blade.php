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
                    <h1 class="text-2xl font-semibold text-black">{{$title}}</h1> 
                </div>
                <div class="flex items-center space-x-3">
                    
                    <div class="bg-white border flex items-center overflow-hidden relative rounded-lg">
                        <i class="pl-4 -mr-2 relative uil-search"></i>
                        <input class="flex-1 max-h-9" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
            @if($rows != "null")
                <div class="card-block">
                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('field_isbn') }}</th>
                                    <th>{{ __('field_book') }}</th>
                                    <th>{{ __('field_issue_date') }}</th>
                                    <th>{{ __('field_due_return_date') }}</th>
                                    <th>{{ __('field_return_date') }}</th>
                                    <th>{{ __('field_status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $rows as $key => $row )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->book->isbn ?? '' }}</td>
                                    <td>{{ $row->book->title ?? '' }}</td>
                                    <td>
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->issue_date)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->issue_date)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->due_date)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->due_date)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($row->return_date))
                                        @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->return_date)) }}
                                        @else
                                            {{ date("Y-m-d", strtotime($row->return_date)) }}
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if( $row->status == 0 )
                                        <span class="badge badge-pill badge-danger">{{ __('status_lost') }}</span>

                                        @elseif( $row->status == 1 )
                                        @if($row->due_date < date("Y-m-d"))
                                        <span class="badge badge-pill badge-danger">{{ __('status_delay') }}</span>
                                        @else
                                        <span class="badge badge-pill badge-primary">{{ __('status_issued') }}</span>
                                        @endif

                                        @elseif( $row->status == 2 )
                                        <span class="badge badge-pill badge-success">{{ __('status_returned') }}</span>
                                        @if($row->due_date < $row->return_date)
                                        <span class="badge badge-pill badge-danger">{{ __('status_delayed') }}</span>
                                        @endif
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
@endsection
<!-- End Content-->

@endsection
