@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} <span class="fw-bolder fst-italic">{{$row->student->first_name}} {{$row->student->last_name}}'s</span> {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-block">
                        <div class="row">
                            <!-- Form Start -->
                            <fieldset class="row scheduler-border">
                                <div class="col-md-6"> 
                                    {{-- <div class="form-group col-md-12">
                                        <label for="student">{{ __('Student Name') }} <span>*</span></label>
                                        <select class="form-control select2" name="student_id" id="student_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($students as $student)
                                            <option value="{{ $student->student_id }} " @if($student->student_id == $row->student_id) selected @endif>{{ $student->first_name }} {{ $student->last_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_student_id') }}
                                        </div>
                                    </div> --}}
                                    <div class=" form-group col-md-12">
                                        <label for="category_id">{{ __('Category') }} <span class="text-danger">*</span>
                                        </label>
                                        <select required name="category_id" id="category_id" class="form-control select2">
                                            <option value="" readonly>Select Category</option>
                                            @forelse ($student_report_categories as $student_report_category)
                                                <option value="{{ $student_report_category->id }}" @if($student_report_category->id == $row->category_id) selected @endif> 
                                                    {{ $student_report_category->name}}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="date">{{ __('Date') }} <span>*</span></label>
                                        <input type="date" class="form-control" name="date" id="date" value="{{$row->date}}"required>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('Date') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="reason">{{ __('Reason') }} <span>*</span></label>
                                        <textarea  type="text" class="form-control"  name="reason" id="reason" rows="3" required>{{$row->reason}}</textarea>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('Reason') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12">
                                        <label for="note">{{ __('Note') }} <span>*</span></label>
                                        <textarea  type="text" class="form-control"  name="note" id="note" rows="10" required>{{$row->note}}</textarea>
    
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('note') }}
                                        </div>
                                    </div>
                                </div>
                            </fieldset>   
                            <!-- Form End -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection