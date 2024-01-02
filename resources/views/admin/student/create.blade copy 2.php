@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

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

                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data" style="display: none;">
                    @csrf
                      
                        <h3>{{ __('tab_basic_info') }}</h3>
                        <content class="form-step">
                            <!-- Form Start -->
                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_first_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_last_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="father_name">{{ __('field_father_name') }}</label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="{{ old('father_name') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_father_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="father_occupation">{{ __('field_father_occupation') }}</label>
                                <input type="text" class="form-control" name="father_occupation" id="father_occupation" value="{{ old('father_occupation') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_father_occupation') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mother_name">{{ __('field_mother_name') }}</label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="{{ old('mother_name') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_mother_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mother_occupation">{{ __('field_mother_occupation') }}</label>
                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="{{ old('mother_occupation') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_mother_occupation') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_phone') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">{{ __('field_email') }} <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_email') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="">{{ __('select') }}</option>
                                    <option value="1" @if( old('gender') == 1 ) selected @endif>{{ __('gender_male') }}</option>
                                    <option value="2" @if( old('gender') == 2 ) selected @endif>{{ __('gender_female') }}</option>
                                    <option value="3" @if( old('gender') == 3 ) selected @endif>{{ __('gender_other') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_gender') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="dob" id="dob" value="{{ old('dob') }}" required max="{{now()->format('Y-m-d')}}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_dob') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="marital_status">{{ __('field_marital_status') }}</label>
                                <select class="form-control" name="marital_status" id="marital_status">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="1" @if( old('marital_status') == 1 ) selected @endif>{{ __('marital_status_single') }}</option>
                                    <option value="2" @if( old('marital_status') == 2 ) selected @endif>{{ __('marital_status_married') }}</option>
                                    <option value="3" @if( old('marital_status') == 3 ) selected @endif>{{ __('marital_status_widowed') }}</option>
                                    <option value="4" @if( old('marital_status') == 4 ) selected @endif>{{ __('marital_status_divorced') }}</option>
                                    <option value="5" @if( old('marital_status') == 5 ) selected @endif>{{ __('marital_status_other') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_marital_status') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="blood_group">{{ __('field_blood_group') }}</label>
                                <select class="form-control" name="blood_group" id="blood_group">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="1" @if( old('blood_group') == 1 ) selected @endif>{{ __('A+') }}</option>
                                    <option value="2" @if( old('blood_group') == 2 ) selected @endif>{{ __('A-') }}</option>
                                    <option value="3" @if( old('blood_group') == 3 ) selected @endif>{{ __('B+') }}</option>
                                    <option value="4" @if( old('blood_group') == 4 ) selected @endif>{{ __('B-') }}</option>
                                    <option value="5" @if( old('blood_group') == 5 ) selected @endif>{{ __('AB+') }}</option>
                                    <option value="6" @if( old('blood_group') == 6 ) selected @endif>{{ __('AB-') }}</option>
                                    <option value="7" @if( old('blood_group') == 7 ) selected @endif>{{ __('O+') }}</option>
                                    <option value="8" @if( old('blood_group') == 8 ) selected @endif>{{ __('O-') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_blood_group') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="national_id">{{ __('field_national_id') }}</label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="{{ old('national_id') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_national_id') }}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_tongue">{{ __('field_mother_tongue') }}</label>
                                <select class="form-control" name="mother_tongue" id="mother_tongue">
                                  <option value="">{{ __('select') }}</option>
                                    @foreach ($mother_tongues as $key => $mother_tongue)
                                        <option value="{{$key}}">{{$mother_tongue['label']}}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_national_id') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="passport_no">{{ __('field_passport_no') }}</label>
                                <input type="text" class="form-control" name="passport_no" id="passport_no" value="{{ old('passport_no') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_passport_no') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="religion">{{ __('field_religion') }}</label>
                                <input type="text" class="form-control" name="religion" id="religion" value="{{ old('religion') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_religion') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="admission_date">{{ __('field_admission_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="admission_date" id="admission_date" value="{{ date('Y-m-d') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_admission_date') }}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="admission_no">{{ __('field_admission_no') }} </label>
                                <input type="text" class="form-control" name="admission_no" id="admission_no" value="{{ old('admission_no') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_admission_no') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                              <label for="roll_no">{{ __('field_roll_no') }} </label>
                              <input type="text" class="form-control" name="roll_no" id="roll_no" value="{{ old('roll_no') }}" >

                              <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_roll_no') }}
                              </div>
                          </div>
                          

                          <div class="form-group col-md-4">
                            <label for="identification_marks">{{ __('field_identification_marks') }} </label>
                            <input type="text" class="form-control" name="identification_marks" id="identification_marks" value="{{ old('identification_marks') }}" >

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_identification_marks') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="joining_date">{{ __('field_joining_date') }} </label>
                            <input type="date" class="form-control date" name="joining_date" id="joining_date" value="{{ date('Y-m-d') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_joining_date') }}
                            </div>
                        </div>

                      <div class="form-group col-md-4">
                        <label for="distance_from_residence">{{ __('field_distance_from_residence') }}</label>
                        <input type="text" class="form-control" name="distance_from_residence" id="distance_from_residence" value="{{ old('distance_from_residence') }}" >

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_distance_from_residence') }}
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="phc">{{ __('field_phc') }} </label>
                        <input type="text" class="form-control" name="phc" id="phc" value="{{ old('phc') }}">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_phc') }}
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="user_category_id">{{ __('field_caste') }} <span>*</span></label>
                        <select name="user_category_id" id="" class="form-control select2">
                          <option value="" readonly>Select Caste</option>
                          @foreach ($user_categories as $user_category)
                            <option value="{{$user_category->id}}">{{$user_category->name}}</option>
                          @endforeach
                        </select>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_caste') }}
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="seat_type_id">{{ __('field_seat_type') }} <span>*</span></label>
                        <select name="seat_type_id" id="" class="form-control select2">
                          <option value="" readonly>Select Seat Type</option>
                          @foreach ($seat_types as $seat_type)
                            <option value="{{$seat_type->id}}">{{$seat_type->name}}</option>
                          @endforeach
                        </select>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_seat_type') }}
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="admission_type_id">{{ __('field_admission_type') }} <span>*</span></label>
                        <select name="admission_type_id" id="" class="form-control select2">
                          <option value="" readonly>Select Admission Type</option>
                          @foreach ($admission_types as $admission_type)
                            <option value="{{$admission_type->id}}">{{$admission_type->name}}</option>
                          @endforeach
                        </select>
  
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_admission_type') }}
                        </div>
                      </div>
                            </fieldset>
                            </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                              <fieldset class="row scheduler-border">
                                <legend>{{ __('field_academic') }} {{ __('field_year') }}</legend>
                              <div class="form-group col-md-6">
                                  <label for="academic_year_from">{{ __('field_academic_year_from') }} <span>*</span></label>
                                  <input type="month" class="form-control" name="academic_year_from" id="academic_year_from" value="{{ old('academic_year_from') }}" required>
  
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_first_name') }}
                                  </div>
                              </div>
  
                              <div class="form-group col-md-6">
                                  <label for="academic_year_to">{{ __('field_academic_year_to') }} <span>*</span></label>
                                  <input type="month" class="form-control" name="academic_year_to" id="academic_year_to" value="{{ old('academic_year_to') }}" required>
  
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_academic_year_to') }}
                                  </div>
                              </div>
                              </fieldset>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend>{{ __('field_present') }} {{ __('field_address1') }}</legend>
                                
                                @include('common.inc.present_province')
                                <div class="form-group col-md-6">
                                  <label for="pincode">{{ __('Pincode') }}</label>
                                  <input type="number" class="form-control" name="present_pincode" id="present_pincode" value="{{ old('present_pincode') }}">
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Pincode') }}
                                  </div>
                              </div>

                                <div class="form-group col-md-6">
                                  <label for="type">{{ __('Type') }}</label>
                                  <select class="form-control" name="type" id="type">
                                      <option value="">{{ __('select') }}</option>
                                      @foreach($address_categories as $key => $category)
                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                      @endforeach
                                  </select>
  
                                  <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Type') }}
                                  </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="present_address_1">{{ __('field_address1') }}</label>
                                    <input type="text" class="form-control" name="present_address_1" id="present_address_1" value="{{ old('present_address_1') }}">

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_address1') }}
                                    </div>
                                </div>
                               <div class="form-group col-md-12">
                                  <label for="present_address">{{ __('Address2') }}</label>
                                  <input type="text" class="form-control" name="present_address_2" id="present_address_2" value="{{ old('present_address_2') }}">
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Adderss2') }}
                                  </div>
                              </div>
                              </fieldset>
                              </div>

                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend>{{ __('field_permanent') }} {{ __('field_address') }}</legend>
                                @include('common.inc.permanent_province')
                                <div class="form-group col-md-6">
                                  <label for="permanent_pincode">{{ __('Pincode') }}</label>
                                  <input type="number" class="form-control" name="permanent_pincode" id="permanent_pincode" value="{{ old('permanent_pincode') }}">

                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('Pincode') }}
                                  </div>
                              </div>
                                <div class="form-group col-md-6">
                                  <label for="type">{{ __('Type') }}</label>
                                  <select class="form-control" name="type" id="type">
                                      <option value="">{{ __('select') }}</option>
                                      @foreach($address_categories as $key => $category)
                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                      @endforeach
                                  </select>
  
                                  <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Type') }}
                                  </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="permanent_address_1">{{ __('field_address1') }}</label>
                                    <input type="text" class="form-control" name="permanent_address_1" id="permanent_address_1" value="{{ old('permanent_address_1') }}">

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_address1') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="permanent_address_2">{{ __('field_address2') }}</label>
                                    <input type="text" class="form-control" name="permanent_address_2" id="permanent_address_2" value="{{ old('permanent_address_2') }}">

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_address2') }}
                                    </div>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                            <!-- Form End -->
                        </content>
                      {{-- Guardian Info start --}}
                        <h3>{{ __('Guardian Info') }}</h3>
                        <content class="form-step">
                          <fieldset class="row scheduler-border">
                            <legend>{{ __('Guardian Info') }}</legend>
                            <div id="inputFormField" class="row">
                                <div class="form-group col-md-4">
                                  <label for="relation" class="form-label">{{ __('field_relation') }} <span>*</span></label>
                                  <select class="form-control" name="relation_id[]" id="relation_id">
                                      <option value="">{{ __('select') }}</option>
                                      @foreach ($relations as $key => $relation)
                                        <option value="{{$key}}">{{$relation['label']}}</option>
                                    @endforeach
                                  </select>
                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_relation') }}
                                  </div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="guardian_name">{{ __('Name') }}</label>
                                  <input type="text" class="form-control" name="guardian_name[]" id="guardian_name" value="{{ old('guardian_name') }}">

                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('guardian_name') }}
                                  </div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="occupation">{{ __('Occupation') }}</label>
                                  <input type="text" class="form-control" name="occupation[]" id="occupation" value="{{ old('occupation') }}">

                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('occupation') }}
                                  </div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="annual_income">{{ __('Annual Income') }}</label>
                                  <input type="text" class="form-control" name="annual_income[]" id="annual_income" value="{{ old('annual_income') }}">

                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('annual_income') }}
                                  </div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="guardian_phone">{{ __('phone') }}</label>
                                  <input type="number" class="form-control" name="guardian_phone[]" id="guardian_phone" value="{{ old('guardian_phone') }}">

                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('guardian_phone') }}
                                  </div>
                              </div>
                                <div class="form-group col-md-4">
                                  <label for="address" class="form-label">{{ __('field_address') }} <span>*</span></label>
                                  <input type="text" class="form-control" name="guardian_addresses[]" id="address" value="{{ old('guardian_addresses') }}" required>

                                  <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_address') }}
                                  </div>
                              </div>
                            <div class="form-group col-md-4">
                              <button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button>
                            </div>
                          </div>
                          <div id="newField" class="clearfix"></div>
                            <div class="form-group">
                                <button id="addField" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                            </div>
                          </fieldset>
                        </content>
                      {{--Guardian Info end  --}}
                        <h3>{{ __('tab_educational_info') }}</h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('tab_educational_info') }}</legend>
                            <div class="form-group col-md-3">
                                <label for="school_name">{{ __('field_school_name') }}</label>
                                <input type="text" class="form-control" name="school_name" id="school_name" value="{{ old('school_name') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_school_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_exam_id">{{ __('field_exam_id') }}</label>
                                <input type="text" class="form-control" name="school_exam_id" id="school_exam_id" value="{{ old('school_exam_id') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_exam_id') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_graduation_year">{{ __('field_graduation_year') }}</label>
                                <input type="text" class="form-control" name="school_graduation_year" id="school_graduation_year" value="{{ old('school_graduation_year') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_graduation_year') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_graduation_point">{{ __('field_graduation_point') }}</label>
                                <input type="text" class="form-control" name="school_graduation_point" id="school_graduation_point" value="{{ old('school_graduation_point') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_graduation_point') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="board">{{ __('field_board') }}</label>
                                <input type="text" class="form-control" name="payload[board]" id="board" value="{{ old('board') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_board') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="hall_ticket_no">{{ __('field_hall_ticket_no') }}</label>
                                <input type="number" class="form-control" name="payload[hall_ticket_no]" min="0" id="hall_ticket_no" value="{{ old('hall_ticket_no') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_hall_ticket_no') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="year_of_passing">{{ __('field_year_of_passing') }}</label>
                                <input type="month" class="form-control" name="payload[year_of_passing]" id="year_of_passing" value="{{ old('year_of_passing') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_year_of_passing') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="marks">{{ __('field_marks') }}</label>
                                <input type="text" class="form-control" name="payload[marks]" id="marks" value="{{ old('marks') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_marks') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="percenteage">{{ __('field_percenteage') }}</label>
                                <input type="text" class="form-control" name="payload[percenteage]" id="percenteage" value="{{ old('percenteage') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_percenteage') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="institution">{{ __('field_institution') }}</label>
                                <input type="text" class="form-control" name="payload[institution]" id="institution" value="{{ old('institution') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_institution') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="grade">{{ __('field_grade') }}</label>
                                <select class="form-control" name="payload[grade]" id="grade">
                                  <option value="">{{ __('select') }}</option>
                                  <option value="1" @if( old('grade') == 1 ) selected @endif>{{ __('A') }}</option>
                                  <option value="2" @if( old('grade') == 2 ) selected @endif>{{ __('A+') }}</option>
                                  <option value="3" @if( old('grade') == 3 ) selected @endif>{{ __('B') }}</option>
                                  <option value="4" @if( old('grade') == 4 ) selected @endif>{{ __('B+') }}</option>
                                  <option value="5" @if( old('grade') == 5 ) selected @endif>{{ __('C') }}</option>
                                  <option value="6" @if( old('grade') == 6 ) selected @endif>{{ __('C+') }}</option>
                                  <option value="7" @if( old('grade') == 7 ) selected @endif>{{ __('D') }}</option>
                                  <option value="8" @if( old('grade') == 8 ) selected @endif>{{ __('E') }}</option>
                              </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_grade') }}
                                </div>
                            </div>

                            </fieldset>

                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-3">
                                <label for="collage_name">{{ __('field_collage_name') }}</label>
                                <input type="text" class="form-control" name="collage_name" id="collage_name" value="{{ old('collage_name') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_collage_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_exam_id">{{ __('field_exam_id') }}</label>
                                <input type="text" class="form-control" name="collage_exam_id" id="collage_exam_id" value="{{ old('collage_exam_id') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_exam_id') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_graduation_year">{{ __('field_graduation_year') }}</label>
                                <input type="text" class="form-control" name="collage_graduation_year" id="collage_graduation_year" value="{{ old('collage_graduation_year') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_graduation_year') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_graduation_point">{{ __('field_graduation_point') }}</label>
                                <input type="text" class="form-control" name="collage_graduation_point" id="collage_graduation_point" value="{{ old('collage_graduation_point') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_graduation_point') }}
                                </div>
                            </div>
                            </fieldset>

                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_academic_information') }}</legend>
                            <div class="form-group col-md-3">
                                <label for="student_id">{{ __('field_student_id') }} <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="student_id" id="student_id" value="{{ old('student_id') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_student_id') }}
                                </div>
                            </div>
                                    @include('common.inc.subject_search')

                            <div class="form-group col-md-6">
                                <label for="status">{{ __('field_status') }}</label>
                                <select class="form-control select2" name="statuses[]" id="status" multiple>
                                    @foreach( $statuses as $status )
                                    <option value="{{ $status->id }}" @if(old('status') == $status->id) selected @endif>{{ $status->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_status') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Managed By</label>
                                <select class="form-control select2" name="managed_by[]" id="managed_by"multiple>
                                    @foreach($teachers as $key => $teacher)
                                      <option value="{{ $teacher->id }}" @if($key == 1) selected @endif>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Managed By') }}
                                </div>
                            </div>

                            </fieldset>
                            <!-- Form End--->
                        </content>
                        <h3>{{ __('Entrance Info') }}</h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('Entrance Info') }}</legend>
                            <div class="form-group col-md-3">
                                <label for="entrance_type">{{ __('Entrance Type') }}</label>
                                <input type="text" class="form-control" name="payload[entrance_type]" id="entrance_type" value="{{ old('entrance_type') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_entrance_type') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                              <label for="hall_ticket_no">{{ __('Hall Ticket No') }}</label>
                              <input type="number" class="form-control" name="payload[hall_ticket_number]" id="hall_ticket_no" value="{{ old('hall_ticket_number') }}">
                              <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_hall_ticket_no') }}
                              </div>
                          </div>
                          <div class="form-group col-md-3">
                            <label for="rank">{{ __('Rank') }}</label>
                            <select class="form-control" name="payload[rank]" id="rank">
                              <option value="">{{ __('select') }}</option>
                              <option value="1" @if( old('rank') == 1 ) selected @endif>{{ __('1') }}</option>
                              <option value="2" @if( old('rank') == 2 ) selected @endif>{{ __('2') }}</option>
                              <option value="3" @if( old('rank') == 3 ) selected @endif>{{ __('3') }}</option>
                              <option value="4" @if( old('rank') == 4 ) selected @endif>{{ __('4') }}</option>
                          </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_grade') }}
                            </div>
                          </div>

                       </fieldset>
                            <!-- Form End--->
                        </content>
                        {{-- education info end --}}
                        <h3>{{ __('tab_documents') }}</h3>
                        <content class="form-step">
                            <!-- Form Start--->

                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="photo">{{ __('field_photo') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                                <input type="file" class="form-control" name="photo" id="photo" value="{{ old('photo') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_photo') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="signature">{{ __('field_signature') }}: <span>{{ __('image_size', ['height' => 100, 'width' => 300]) }}</span></label>
                                <input type="file" class="form-control" name="signature" id="signature" value="{{ old('signature') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_signature') }}
                                </div>
                            </div>
                            </fieldset>

                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_upload') }} {{ __('field_document') }}</legend>

                            <div class="container-fluid">
                            <div id="newDocument" class="clearfix"></div>
                            <div class="form-group">
                                <button id="addDocument" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                            </div>
                            </div>

                            </fieldset>
                            <!-- Form End--->

                        </content>

                        <h3>{{ __('Banks Info') }}</h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                  <div class="col-md-12 row">
                                    <div class=" col-md-6">
                                        <label for="bank_name">{{ __('Bank') }}</label>
                                            <select class="form-control" name="bank_name[]" id="bank_name" >
                                                <option value="">{{ __('select') }}</option>
                                                @foreach ($banks_name as $key => $status)
                                                <option value="{{$key}}">{{ $status['label'] }}</option>
                                                @endforeach
                                            </select>
                                        <div class="invalid-feedback"> {{ __('Banks') }}
                                        </div>
                                    </div>
                                    <div class="co-md-6 mt-3 ">
                                      <label for="">Add Account Type</label>
                                      <div class="form-check ">
                                          <input name="type[]" value="Current" type="radio" class="form-check-input pb-1"
                                              ="">
                                          <label class="form-check-label pl-2 mb-1 " for="current">Current</label>
                                      </div>
                                      <div class="form-check mb-2">
                                          <input name="type[]" value="Saving" type="radio" class="form-check-input pb-1"
                                              ="">
                                          <label class="form-check-label pl-2 mb-1 " for="saving">Saving</label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                        <label for="phone" class="control-label">{{ 'Account Holder Name' }}</label>
                                        <input name="account_holder_name[]"  type="text" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character ."class="form-control"
                                            placeholder="Enter Account Holder Name">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('account_no') ? 'has-error' : '' }}">
                                        <label for="account_no" class="control-label">{{ 'Account Number' }}</label>
                                        <input name="account_no[]"  type="number" min="0" id="numberInput"
                                            class="form-control " placeholder="Enter Account Number">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('ifsc_code') ? 'has-error' : '' }}">
                                        <label for="ifsc_code" class="control-label">
                                            {{ 'IFSC Code' }}
                                        </label>
                                        <input   type="text" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."
                                            name="ifsc_code[]" id="ifsc_code" class="form-control " placeholder="Enter Ifsc Code">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                                        <label for="singin-email">Branch </label>
                                        <input name="branch[]"  type="text" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control"
                                            placeholder="Enter Branch ">
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <button id="removeBank" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button>
                                  </div>
                                  <div id="newFieldBank" class="clearfix"></div>
                                  <div class="form-group">
                                      <button id="addBank" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                                  </div>
                                </fieldset>
                              </div>
                            </div>
                            <!-- Form End--->
                        </content>

                    </form>
                    </div>

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
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {

            }
        });
    </script>

    <script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addField', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="inputFormField" class="row">';
            // html += '<div class="form-group col-md-4"><label for="relation" class="form-label">{{ __('field_relation') }} <span>*</span></label><input type="text" class="form-control" name="relations[]" id="relation" value="{{ old('relation') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_relation') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="relation" class="form-label">{{ __('field_relation') }} <span>*</span></label><select class="form-control" name="relation_id[]" id="relation_id"><div class="invalid-feedback"><option value="">{{ __('select') }}</option>foreach($relations as $key => $relation) {<option value="{{$key}}">{{$relation['label']}}</option>}</select><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_relation') }}</div></div>';
            // html += '<div class="form-group col-md-4"><label for="relation" class="form-label">{{ __('field_relation') }} <span>*</span></label><select class="form-control" name="relation_id" id="relation_id"><div class="invalid-feedback"><option value="">{{ __('select') }}</option>foreach($relations as $key => $relation) {<option value="{{$key}}">{{$relation['label']}}</option>}</select></div></div>';
            html += '<div class="form-group col-md-4"><label for="guardian_name" class="form-label">{{ __('field_name') }} <span>*</span></label><input type="text" class="form-control" name="guardian_name[]" id="guardian_name" value="{{ old('guardian_name') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_name') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="occupation" class="form-label">{{ __('field_occupation') }} <span>*</span></label><input type="text" class="form-control" name="occupation[]" id="occupation" value="{{ old('occupation') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_occupation') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="guardian_phone" class="form-label">{{ __('field_phone') }} <span>*</span></label><input type="number" class="form-control" name="guardian_phone[]" id="guardian_phone" value="{{ old('guardian_phone') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_phone') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="guardian_addresses" class="form-label">{{ __('field_address') }} <span>*</span></label><input type="text" class="form-control" name="guardian_addresses[]" id="guardian_addresses" value="{{ old('guardian_addresses') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_address') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="annual_income" class="form-label">{{ __('field_address') }} <span>*</span></label><input type="text" class="form-control" name="annual_income[]" id="annual_income" value="{{ old('annual_income') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_address') }}</div></div>';
            html += '<div class="form-group col-md-4"><button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button></div>';
            html += '</div>';

            $('#newField').append(html);
        });

        // remove Field
        $(document).on('click', '#removeField', function () {
            $(this).closest('#inputFormField').remove();
        });
    }(jQuery));
    </script>

    <script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addDocument', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="documentFormField" class="row">';
            html += '<div class="form-group col-md-4"><label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label><input type="text" class="form-control" name="titles[]" id="title" value="{{ old('title') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="document" class="form-label">{{ __('field_document') }} <span>*</span></label><input type="file" class="form-control" name="documents[]" id="document" value="{{ old('document') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_document') }}</div></div>';
            html += '<div class="form-group col-md-4"><button id="removeDocument" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button></div>';
            html += '</div>';

            $('#newDocument').append(html);
        });

        // remove Field
        $(document).on('click', '#removeDocument', function () {
            $(this).closest('#documentFormField').remove();
        });
        
   // add bank Field
   $(document).on('click', '#addBank', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="inputFormField" class="row">';
            html += '<div class="form-group col-md-4"> <label for="bank_name">{{ __('Bank') }}</label><select class="form-control" name="bank_name[]" id="bank_name"><div class="invalid-feedback"><option value="">{{ __('select') }}</option>foreach($banks_name as $key => $status) {<option value="{{$key}}">{{$status['label']}}</option>}</select><div class="invalid-feedback">{{ __('required_field') }} {{ __('bank_name') }}</div></div>';
            html += '<div class="form-group col-md-4"> <label for="bank_name">{{ __('Account Holder Name') }}</label><input name="account_holder_name[]"  type="text"  title="Please enter first letter alphabet and at least one alphabet character ."class="form-control" placeholder="Enter Account Holder Name"><div class="invalid-feedback">{{ __('required_field') }} {{ __('bank_name') }}</div></div>';
            html += '<div class="form-group col-md-4"> <label for="bank_name">{{ __('Account Number') }}</label> <input name="account_no[]"  type="number" min="0" id="numberInput"class="form-control " placeholder="Enter Account Number"><div class="invalid-feedback">{{ __('required_field') }} {{ __('account_number') }}</div></div>';
            html += '<div class="form-group col-md-4"> <label for="bank_name">{{ __('Ifsc Code') }}</label>  <input name="ifsc_code[]"  type="text" pattern="[a-zA-Z]+.*"  title="Please enter first letter alphabet and at least one alphabet character is required." id="ifsc_code" class="form-control " placeholder="Enter Ifsc Code"><div class="invalid-feedback">{{ __('required_field') }} {{ __('ifsc_code') }}</div></div>';
            html += '<div class="form-group col-md-4"> <label for="branch">{{ __('Branch') }}</label> <input name="branch[]"  type="text" pattern="[a-zA-Z]+.*"  title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control" placeholder="Enter Branch "><div class="invalid-feedback">{{ __('required_field') }} {{ __('branch') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="">Add Account Type</label><div class="form-check "><input name="type" value="Current" type="radio" class="form-check-input pb-1"><label class="form-check-label pl-2 mb-1 " for="current">Current</label></div><div class="form-check mb-2"><input name="type[]" value="Saving" type="radio" class="form-check-input pb-1"><label class="form-check-label pl-2 mb-1 " for="saving">Saving</label></div><div class="invalid-feedback">{{ __('required_field') }} {{ __('bank_name') }}</div></div>';
            html += '<div class="form-group col-md-4"><button id="removeBank" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button></div>';
            html += '</div>';                 
            $('#newFieldBank').append(html);
        });
          // remove Field
          $(document).on('click', '#removeBank', function () {
                 $(this).closest('#inputFormField').remove();
            });
    }(jQuery));
    </script>
    


<!-- Filter Search -->
@include('common.js.batch_filter')
@endsection