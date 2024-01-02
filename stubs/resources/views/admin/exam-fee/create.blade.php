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
                      <form class="needs-validation" novalidate method="get" action="{{ route($route.'.create') }}">
                          <div class="row gx-2">
                              @include('common.inc.student_search_filter')
                              <div class="form-group col-md-3">
                                  <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                              </div>
                          </div>
                      </form>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
            @if(isset($rows))
                @if(count($rows) > 0)
                  <div class="col-sm-12">
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="payment_method" value="2">
                      <input type="hidden" name="students" class="students" value="">
                      <div class="card">
                        <div class="card-block">
                            <input type="text" name="faculty" value="{{ $selected_faculty }}" hidden>
                            <input type="text" name="program" value="{{ $selected_program }}" hidden>
                            <input type="text" name="session" value="{{ $selected_session }}" hidden>
                            <input type="text" name="semester" value="{{ $selected_semester }}" hidden>
                            <input type="text" name="section" value="{{ $selected_section }}" hidden>


                            <!-- [ Data table ] start -->
                            <div class="table-responsive">
                                <table class="display table nowrap table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                              <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select">
                                                  <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                              </div>
                                            </th>
                                            <th>{{ __('field_student_id') }}</th>
                                            <th>{{ __('field_student') }}</th>
                                            <th>{{ __('field_credit_hour_short') }}</th>
                                            <th>{{ __('field_program') }}</th>
                                            <th>{{ __('field_session') }}</th>
                                            <th>{{ __('field_semester') }}</th>
                                            <th>{{ __('field_section') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $rows as $key => $row )
                                        <tr>
                                            <td>
                                                <div class="checkbox checkbox-primary d-inline">
                                                  <input type="checkbox" data_id="{{ $row->id }}" id="checkbox-{{ $row->id }}" value="{{ $row->student->id }}">
                                                  <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                              </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.student.show', $row->student->id) }}">
                                                #{{ $row->student->student_id ?? '' }}
                                                </a>
                                            </td>
                                            <td>{{$row->student->full_name}}</td>
                                            <td>
                                                @php
                                                    $total_credits = 0;
                                                    foreach($row->subjects as $subject){
                                                        $total_credits = $total_credits + $subject->credit_hour;
                                                    }
                                                @endphp
                                                {{ $total_credits }}
                                            </td>
                                            <td>{{ $row->program->shortcode ?? '' }}</td>
                                            <td>{{ $row->session->title ?? '' }}</td>
                                            <td>{{ $row->semester->title ?? '' }}</td>
                                            <td>{{ $row->section->title ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- [ Data table ] end -->
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <div class="col-md-8">
                                <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="title">{{ __('field_title') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
    
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_title') }}
                                      </div>
                                  </div>
    
                                  <div class="form-group col-md-6">
                                      <label for="amount">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                      <input type="text" class="form-control autonumber" name="amount" id="amount" value="{{ old('amount') }}" required>
    
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_amount') }}
                                      </div>
                                  </div>
    
                                  <div class="form-group col-md-6">
                                      <label for="date">{{ __('field_date') }} <span>*</span></label>
                                      <input type="date" class="form-control date" name="date" id="date" value="{{ date('Y-m-d') }}" required>
    
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_date') }}
                                      </div>
                                  </div>
    
                                  <div class="form-group col-md-6">
                                    <label for="payment_status" class="form-label">{{ __('field_payment_status') }} </label>
                                    <select class="form-control" name="payment_status" id="payment_status">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach ($payment_statuses as $key => $payment_status)
                                          <option value="{{$key}}" @if( old('payment_status') == $key ) selected @endif>{{ $payment_status['label'] }}</option>
                                        @endforeach
                                    </select>
    
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_payment_status') }}
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('field_note') }}</label>
                                    <textarea class="form-control" rows="4" name="note" id="note">{{ old('note') }}</textarea>
    
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_note') }}
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('field_category') }}</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                      <option value="">{{ __('select') }}</option>
                                      @foreach ($categories as $key => $category)
                                        <option value="{{$category->id}}">{{ $category->title }}</option>
                                      @endforeach
                                  </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_category') }}
                                    </div>
                                </div>
                              </div>
                            </div>
                            <!-- Form End -->
                          </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success saveBtn"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                      </div>
                    </form>
                  </div>
                @else
                  <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="text-center">
                                <h6>No Student Found..</h6>
                            </div>
                        </div>
                    </div>
                  </div>
                @endif
            @endif
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
@section('page_js')

<script>
  $(document).ready(function() {
    $(".saveBtn").on('click',function(e){
            var numberOfChecked = $("input[data_id]:checked").length;
            if(numberOfChecked <= 0){
                e.preventDefault();
                alert("{{ __('select') }} {{ __('field_student_id') }}");
            }

            var students = [];
            $.each($("input[data_id]:checked"), function(){
                students.push($(this).val());
            });

            $(".students").val( students.join(',') );
        });
    });
    $(".all_select").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $("input:checkbox").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $("input:checkbox").prop('checked', false);
        }
    });
</script>

@yield('sub-script')
@endsection