@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-7 col-lg-6">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ 'Student Details' }}</h4>
                        <div>
                            <a href="{{ $row->link }}" class="text-primary" target="_blank"><i class="fa fa-eye"></i> Documents</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    {{-- <tr>
                                        <th>ID</th>
                                        <td>{{ $row->getPrefix() }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th> Requested By </th>
                                        <td>  
                                            @if ($row->role_id != 0)
                                                {{@$row->user->full_name}}
                                            @else
                                                {{@$row->student->full_name}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> Approved By </th>
                                        <td> {{@$row->approver->full_name  }} </td>
                                    </tr>
                                    <tr>
                                        <th> Created At </th>
                                        <td> {{ ($row->created_at) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> Note </th>
                                        <td>{{ $row->note }}</div></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between left">
                            <div class="text-muted fw-600" title="Last Updated At">
                                <i class="fas fa-clock"></i>
                                {{$row->updated_at->diffForHumans()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <!-- Details View Start -->
                <div class="row">
                    <form class="needs-validation" novalidate action="{{ route('admin.update-approval', $row->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5>{{__('Submission Action')}}</h5> 
                                <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                            </div>
                            <div class="card-block">
                                <div class="col-md-12 mt-2">
                                    <div class="form-group d-inline">
                                        <div class="radio radio-success d-inline">
                                            <input type="radio" name="status" value="1" id="approved-{{ $row->id }}" @if($row->status == 1) checked @endif required>
                                            <label for="approved-{{ $row->id }}" class="cr">{{ __('status_approved') }}</label>
                                        </div>
        
                                        <div class="radio radio-danger d-inline">
                                            <input type="radio" name="status" value="2" id="rejected-{{ $row->id }}" @if($row->status == 2) checked @endif required>
                                            <label for="rejected-{{ $row->id }}" class="cr">{{ __('status_rejected') }}</label>
                                        </div>
        
                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_status') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="comment">{{ __('Comment') }} :</label> 
                                    <textarea class="form-control" name="comment" type="text" id="comment"rows="3" value="{{$row->comment}}" placeholder="Enter comment"></textarea>
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