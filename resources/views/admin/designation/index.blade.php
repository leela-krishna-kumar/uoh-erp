@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="total_positions" class="form-label">{{ __('Total Positions') }} <span>*</span></label>
                                <input type="number" class="form-control" name="total_positions" id="total_positions" value="{{ old('total_positions') }}" required>

                                {{-- <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <label for="filled_positions" class="form-label">{{ __('Filled Positions') }} <span>*</span></label>
                                <input type="number" class="form-control" name="filled_positions" id="filled_positions" value="{{ old('filled_positions') }}" required>

                                {{-- <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <label for="job_description" class="form-label">Job Description<span>*</span></label>
                                <textarea type="number" class="form-control" name="job_description" id="job_description" rows="3" required></textarea>
                                {{-- <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div> --}}
                               
                            </div>
                           
                            
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{__('Total Positions')}}</th>
                                        <th>{{__('Filled Positions')}}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>{{$row->total_positions}}</td>
                                        <td>{{$row->filled_positions}}</td>
                                        <td>
                                        
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                            <button type="button" class="btn btn-icon btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#jobDescriptionModal-{{$row->id}}">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            @include('admin.designation.show-modal')
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
@section('page_js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        function CreatePDFfromHTML(id) {
          
       
                $(".actionPdf").addClass('d-none');
                var HTML_Width = $("#html-content-"+id).width();
                var HTML_Height = $("#html-content-"+id).height();
                var top_left_margin = 15;
                var PDF_Width = HTML_Width + (top_left_margin * 2);
                var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
                var canvas_image_width = HTML_Width;
                var canvas_image_height = HTML_Height;

                var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

                html2canvas($("#html-content-"+id)[0], {background :'#FFFFFF',}).then(function (canvas) {
                    var imgData = canvas.toDataURL("image/jpeg", 1.0);
                    var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                    pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                    for (var i = 1; i <= totalPDFPages; i++) { 
                        pdf.addPage(PDF_Width, PDF_Height);
                        pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                    }
                    pdf.save(id);
                });
                $(".actionPdf").removeClass('d-none');
            }
    </script>
@endsection
