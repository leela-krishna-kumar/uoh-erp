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
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                </div>
            </div>
            <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="scholarship_id" value="{{ request()->get('scholarship_id') }}">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group col-md-12">
                                            <label for="student_id">Student<span>*</span></label>
                                            <select class="form-control select2" name="student_id" id="student_id" required>
                                                <option value="">{{ __('select') }}</option>
                                                @foreach($students as $student)
                                                <option value="{{ $student->student_id }}">{{ $student->first_name }}{{ $student->last_name }}</option>
                                                @endforeach
                                            </select>
        
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_student_id') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="amount"> Amount<span>*</span></label>
                                            <input type="number" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" required>
        
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_amount') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="date">Date<span>*</span></label>
                                            <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required>
        
                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_date') }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="status">{{ __('field_status') }}<span>*</span></label>
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach ($statuses as $key => $status)
                                                    <option value="{{$key}}">{{ $status['label'] }}</option>
                                                    @endforeach
                                                </select>
                                            <div class="invalid-feedback"> {{ __('field_status') }}
                                            </div>
                                        </div>
                                      

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label for="note">Note<span>*</span></label>
                                            <textarea type="text" class="form-control" name="note" id="note" rows="12" required>{{ old('note') }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('required_field') }} {{ __('field_note') }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                             </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection