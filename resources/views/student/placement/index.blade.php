@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">     
    <!-- Main Contents -->
    <div class="main_content">
        <!-- Add this code inside your Blade view -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-danger">
                {{ session('success') }}
            </div>
        @endif
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
            
            @if($rows->count() > 0)
            <div class="card-block mt-3">
                <!-- [ Data table ] start -->
                <div class="table-responsive border">
                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('field_company') }}</th>
                                <th title="Date of visit">DOV</th>
                                <th>{{__('Application Deadline')}}</th>
                                <th>{{__('Category')}}</th>
                                <th>{{ __('field_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $rows as $key => $row )
                                <tr>
                                    @php 
                                        $applied = App\Models\PlacedStudent::where('placement_id',$row->id)->where('student_id',Auth::guard('student')->id())->first();
                                    @endphp
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ @$row->company->name }}</td>
                                    <td>{{ $row->date }}</td>
                                    <td>{{ $row->deadline_date  ?? '--' }}</td>
                                    <td>{{ $row->category->name  ?? '--' }}</td>
                                    <td>
                                        @if($applied)
                                        <span class="m-0 p-0">Applied</span>
                                        @else
                                        <span class="btn btn-link apply-btn m-0 p-0" data-id="{{$row->id}}">Apply</span>
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
    @include('student.placement.apply')
    
    @endsection
    {{-- <div id="dialog" title="Dialog Title">
        <p>test</p>
    </div> --}}
<!-- End Content-->
 
@push('script')
<script>
    $(document).on('click', '.apply-btn', function() {
        let placement_id = $(this).data('id');
        $('#placement_id').val(placement_id);
        UIkit.modal('#apply').show();
    });
</script>
@endpush
    

