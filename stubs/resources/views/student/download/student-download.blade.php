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
                    <h1 class="text-2xl font-semibold text-black"> {{$title}}</h1> 
                </div>
                <div class="flex items-center space-x-3">
                    
                    <div class="bg-white border flex items-center overflow-hidden relative rounded-lg">
                        <i class="pl-4 -mr-2 relative uil-search"></i>
                        <input class="flex-1 max-h-9" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
            @if($rows->count() > 0)
            <div class="card-block">
                <!-- [ Data table ] start -->
                <div class="table-responsive">
                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('field_title') }}</th>
                                <th>{{ __('field_type') }}</th>
                                <th>{{ __('field_date') }}</th>
                                <th>{{ __('field_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach( $rows as $key => $row )
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                @php
                                $unread = 0;
                                $user = Auth::guard('student')->user();
                                foreach ($user->unreadNotifications as $notification) {
                                    if($notification->data['type'] == 'content' && $notification->data['id'] == $row->id) {
                                        $unread = 1;
                                    }
                                }
                                @endphp
                                <td>
                                    @if($unread == 1)
                                    <a href="{{ route($route.'.show', $row->id) }}"><b>{{ $row->title }}</b></a>
                                    @else
                                    <a href="{{ route($route.'.show', $row->id) }}">{{ $row->title }}</a>
                                    @endif
                                </td>
                                <td>{{ $row->type->title ?? '' }}</td>
                                <td>
                                    @if(isset($setting->date_format))
                                    {{ date($setting->date_format, strtotime($row->date)) }}
                                    @else
                                    {{ date("Y-m-d", strtotime($row->date)) }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm"><i class="fas fa-eye"></i></a>

                                    @if(is_file('uploads/'.$path.'/'.$row->attach))
                                    <a href="{{ asset('uploads/'.$path.'/'.$row->attach) }}" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
                                    @endif

                                    @if(isset($row->url))
                                    <a href="{{ url($row->url) }}" class="btn btn-icon btn-dark btn-sm" target="_blank"><i class="fas fa-link"></i></a>
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
@endsection
    <!-- End Content-->
    
@endsection


