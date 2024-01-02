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
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5>{{ $title }}</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.fees-master.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('field_bulk_assign') }}</a>
                        </div>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route($route.'.quick.assign.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="student">{{ __('field_student_id') }} <span>*</span></label>
                            <select class="form-control select2" name="student" id="student" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $students as $student )
                                <option value="{{ $student->id }}" data-student_id="{{$student->student->id}}" @if(old('student') == $student->id) selected @endif>{{ $student->student->student_id ?? '' }} - {{ $student->student->first_name ?? '' }} {{ $student->student->last_name ?? '' }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_student_id') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="category">{{ __('field_fees_type') }} <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $categories as $category )
                                <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_fees_type') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="assign_date" class="form-label">{{ __('field_assign') }} {{ __('field_date') }} <span>*</span></label>
                            <input type="date" class="form-control" name="assign_date" id="assign_date" value="{{ date('Y-m-d') }}" readonly required>

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_assign') }} {{ __('field_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="due_date" class="form-label">{{ __('field_due_date') }} <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="{{ date('Y-m-d') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_due_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount" class="form-label">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="number" min="0" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" required>

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>{{ __('field_amount_type') }}</label><br/>
                            <div class="radio d-inline">
                                <input type="radio" name="type" id="type_fixed" value="1" @if( old('type') == null ) checked @elseif( old('type') == 1 )  checked @endif>
                                <label for="type_fixed" class="cr">{{ __('amount_type_fixed') }}</label>
                            </div>
                            <div class="radio d-inline">
                                <input type="radio" name="type" id="type_per_credit" value="2" @if( old('type') == 2 ) checked @endif>
                                <label for="type_per_credit" class="cr">{{ __('amount_type_per_credit') }}</label>
                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
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
@section('page_js')
<script type="text/javascript">
"use strict";
    $("#student").on('change',function(e){
        $('#category').trigger('change');
    });
    $("#category").on('change',function(e){
        $.ajax({
            type:'POST',
            url: "{{ route('get-fee-amount') }}",
            data:{
                _token:$('input[name=_token]').val(),
                fees_type_id: $(this).val(),
                student_id: $('#student').find(':selected').data('student_id'),
            },
            success:function(response){
                $('#amount').val(response);
            }

        });
    });
</script>
@endsection