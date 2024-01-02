@extends('admin.layouts.master')
@section('title', $title)
@section('content')
    <div class="row">
        @can($access.'-action')
        <!-- [ Card ] start -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $title }}</h5>
                </div>
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-block mb-0">
                  <div class="row">
                      <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="book">{{trans_choice('module_requisition_book_name',1) }}<span>*</span></label>
                            <input required type="text" class="form-control" name="book_name" id="book_name" value="{{old('book')}}">
                            
                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('module_requisition_book_name') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="note">{{trans_choice('module_requisition_author_name',1) }}<span>*</span></label>
                            <input required type="text" class="form-control" name="author_name" id="author_name" value="{{old('author')}}">
                            
                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('module_requisition_author_name') }}
                            </div>
                        </div>

                           <div class="form-group col-md-6">
                                <label for="status">{{trans_choice('module_accordion_status',1) }}<span>*</span></label>
                                <select class="form-control select2" name="status" id="status" required>
                                    @foreach( $statuses as $key => $status )
                                    <option value="{{ $key }}" @if($key=='0') selected @endif> {{ $status['label'] }}</option>
                                    @endforeach
                            </select>

                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Status') }}
                                </div>
                            </div>

                        <div class="form-group col-md-6">
                            <label for="note">{{trans_choice('module_requisition_remark',1) }}</label>
                            <textarea type="text" class="form-control" name="remark" id="remark" cols="20" rows="1" value="{{old('remark')}}"></textarea>
                            
                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('module_requisition_remark') }}
                            </div>
                        </div>

                        <!-- Form End -->
                    </div>
                </div>
                <div class="card-footer pt-0 float-right mt-0">
                    <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('btn_save') }}</button>
                </div>
                </form>
            </div>
        </div>
        <!-- [ Card ] end -->
        @endcan
    </div>
@endsection