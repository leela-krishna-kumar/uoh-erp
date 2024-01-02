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
            
            @if($rows->count() > 0)
            <div class="card-block mt-3">
                <!-- [ Data table ] start -->
                <div class="table-responsive border">
                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('field_title') }}</th>
                                <th>{{ __('field_year') }}</th>
                                <th>{{ __('field_description') }}</th>
                                <th>{{ __('field_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $rows as $key => $row )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{!! str_limit(strip_tags($row->title), 50, ' ...') !!}</td>
                                    <td>{{$row->year ?? '--'}}  </td>
                                    <td>{!! str_limit(strip_tags($row->description), 50, ' ...') !!}</td>
                                    <td>
                                        @if(is_file('uploads/'.$path.'/'.$row->file))
                                        <span class="btn btn-link preview-doc-btn m-0 p-0" data-path="{{ asset('uploads/'.$path.'/'.$row->file) }}">Preview</span>
                                        @else
                                        <span >No File</span>
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
    @include('utilities.iframe')
    
    @endsection
    {{-- <div id="dialog" title="Dialog Title">
        <p>test</p>
    </div> --}}
<!-- End Content-->
 
@push('script')
<script>
    $(document).on('click', '.preview-doc-btn', function() {
        let previewUrl = $(this).data('path');
        $('#previewPath').attr('src', previewUrl);
        UIkit.modal('#previewModal').show();
    });
</script>
@endpush
    

