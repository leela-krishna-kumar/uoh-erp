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
                <a href="javascript:void(0)" uk-toggle="target: #addGrievance" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>

                <a href="{{ route('student.student-grievance') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
            </div>
            @if($rows)
            <div class="card-block mt-3">
                <!-- [ Data table ] start -->
                <div class="table-responsive border">
                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('field_category') }}</th>
                                <th>{{ __('field_department') }}</th>
                                <th>{{ __('field_status') }}</th>
                                <th>{{ __('field_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $rows as $key => $row )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->category->name }}</td>
                                    <td>{{ $row->department->title }}</td>
                                    <td>
                                        <span class="badge badge-pill badge-{{App\Models\Grievance::STATUSES[$row->status]['color']}}">{{ App\Models\Grievance::STATUSES[$row->status]['label'] }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-success btn-sm" uk-toggle="target: #showGrievance-{{ $row->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ $row->link }}" class="btn btn-icon btn-secondary btn-sm">
                                            <i class="fas fa-file"></i>
                                        </button>
                                        <!-- Include Show modal -->
                                        @include('student.grievance.include.show')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- [ Data table ] end -->
            </div>
            @else
                <h5 class="text-center p-40">No Grievance Found!</h5>
            @endif
        </div>
        
        @include('student.layouts.footer.student-footer')
        
    </div>
    <!-- Main Contents -->
    
    @include('student.grievance.include.add')
    @endsection
    {{-- <div id="dialog" title="Dialog Title">
        <p>test</p>
    </div> --}}
<!-- End Content-->
 
@push('script')
<script>
     
</script>
@endpush
    

