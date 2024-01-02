@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ 'Grievance Details' }}</h4>
                        <div>
                            <span>Uploaded File:</span> 
                            <a title="View Documents" href="{{$row->link}}" target="_blank" class="btn btn-icon btn-primary btn-sm"><i class="fas fa-file"></i>
                            </a>  
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th> Complaint By </th>
                                        <td> {{@$row->student->full_name}} </td>
                                    </tr>
                                    <tr>
                                        <th> Department Name</th>
                                        <td>
                                            {{@$row->department->title}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> Category</th>
                                        <td>
                                            {{@$row->category->name}}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Created At </th>
                                        <td> {{ ($row->created_at) }}
                                        </td>
                                    </tr>
                                     --}}
                                </tbody>
                            </table>
                            <div>
                                <div>
                                    <span>Description:</span>
                                </div>
                               {{@$row->description}} 
                            </div>
                        </div>
                        <div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <!-- Details View Start -->
                <div class="row">
                    <form class="needs-validation" novalidate action="{{ route('admin.update-grievance', $row->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card" style=" height: 204px;">
                            <div class="card-header d-flex justify-content-between">
                                <h5>{{__('Grievance Action')}}</h5> 
                                <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                            </div>
                            <div class="card-block">
                                <div class="col-md-12 mt-2">
                                    <div class="form-group d-inline">
                                        <div class="mb-2">
                                           <label for=""> Status :</label>
                                        </div>
                                        
                                        <div class="radio radio-success d-inline">
                                            <input type="radio" name="status" value="1" id="resolved-{{ $row->id }}" @if($row->status == 1) checked @endif required>
                                            <label for="resolved-{{ $row->id }}" class="cr">{{ __('Resolved') }}</label>
                                        </div>
        
                                        <div class="radio radio-danger d-inline">
                                            <input type="radio" name="status" value="0" id="in_review-{{ $row->id }}" @if($row->status == 0) checked @endif required>
                                            <label for="in_review-{{ $row->id }}" class="cr">{{ __('In Review') }}</label>
                                        </div>
        
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_status') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>  
                </div>   
                <!-- Details View End -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection