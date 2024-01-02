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
                    <h3>{{ __('tab_profile_info') }}</h3>
                    <content class="form-step">
                       <!-- Form Start -->
                       <div class="row">
                          <div class="col-md-12">
                             <fieldset class="row scheduler-border">
                                <div class="form-group col-md-4">
                                   <label for="staff_id">{{ __('field_staff_id') }} <span>*</span></label>
                                   <input type="text" class="form-control autonumber" name="staff_id" id="staff_id" value="{{ old('staff_id') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_staff_id') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                   <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_first_name') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                   <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_last_name') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="father_name">{{ __('field_father_name') }}</label>
                                   <input type="text" class="form-control" name="father_name" id="father_name" value="{{ old('father_name') }}">
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_father_name') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="mother_name">{{ __('field_mother_name') }}</label>
                                   <input type="text" class="form-control" name="mother_name" id="mother_name" value="{{ old('mother_name') }}">
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_mother_name') }}
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
                                   <label for="role">{{ __('field_role') }} <span>*</span></label>
                                   <select class="form-control" name="roles[]" id="role" required>
                                      <option value="">{{ __('select') }}</option>
                                      @foreach($roles as $role )
                                      <option value="{{ $role->id }}" @if(old('roles') == $role->id) selected @endif>{{ $role->name }}</option>
                                      @endforeach
                                   </select>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_role') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="department">{{ __('field_department') }} <span>*</span></label>
                                   <select class="form-control" name="department" id="department" required>
                                      <option value="">{{ __('select') }}</option>
                                      @foreach( $departments as $department )
                                      <option value="{{ $department->id }}" @if(old('department') == $department->id) selected @endif>{{ $department->title }}</option>
                                      @endforeach
                                   </select>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_department') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="designation">{{ __('field_designation') }} <span>*</span></label>
                                   <select class="form-control" name="designation" id="designation" required>
                                      <option value="">{{ __('select') }}</option>
                                      @foreach( $designations as $designation )
                                      <option value="{{ $designation->id }}" @if(old('designation') == $designation->id) selected @endif>{{ $designation->title }}</option>
                                      @endforeach
                                   </select>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_designation') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                   <input type="date" class="form-control date" name="dob" id="dob" value="{{ old('dob') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_dob') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="joining_date">{{ __('field_joining_date') }} <span>*</span></label>
                                   <input type="date" class="form-control date" name="joining_date" id="joining_date" value="{{ old('joining_date') ?? date('Y-m-d') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_joining_date') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="ending_date">{{ __('field_ending_date') }}</label>
                                   <input type="date" class="form-control date" name="ending_date" id="ending_date" value="{{ old('ending_date') }}">
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_ending_date') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="email">{{ __('field_email') }} <span>*</span></label>
                                   <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_email') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                   <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                   <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" required>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_phone') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for="emergency_phone">{{ __('field_emergency_phone') }}</label>
                                  <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="{{ old('emergency_phone') }}">
                                  <div class="invalid-feedback">
                                     {{ __('required_field') }} {{ __('field_emergency_phone') }}
                                  </div>
                               </div>
                                <div class="form-group col-md-3">
                                   <label for="marital_status">{{ __('field_marital_status') }}</label>
                                   <select class="form-control" name="marital_status" id="marital_status">
                                      <option value="">{{ __('select') }}</option>
                                      <option id="marital_status_single" value="1" @if( old('marital_status') == 1 ) selected @endif>{{ __('marital_status_single') }}</option>
                                      <option value="2" @if( old('marital_status') == 2 ) selected @endif>{{ __('marital_status_married') }}</option>
                                      <option value="3" @if( old('marital_status') == 3 ) selected @endif>{{ __('marital_status_widowed') }}</option>
                                      <option value="4" @if( old('marital_status') == 4 ) selected @endif>{{ __('marital_status_divorced') }}</option>
                                      <option value="5" @if( old('marital_status') == 5 ) selected @endif>{{ __('marital_status_other') }}</option>
                                   </select>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_marital_status') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-3">
                                   <label for="marriage_date">{{ __('Marriage Date') }}</label>
                                   <input type="date" class="form-control" name="marriage_date" id="marriage_date" value="{{ old('marriage_date') }}">
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_marriage_date') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-3">
                                   <label for="device_id">{{ __('Device Id') }}</label>
                                   <input type="text" class="form-control" name="device_id" id="device_id" value="{{ old('device_id') }}">
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('Device Id') }}
                                   </div>
                                </div>
                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-6">
                                  <label for="national_id">{{ __('field_national_id') }}</label>
                                  <input type="text" class="form-control" name="national_id" id="national_id" value="{{ old('national_id') }}">
                                  <div class="invalid-feedback">
                                     {{ __('required_field') }} {{ __('field_national_id') }}
                                  </div>
                               </div>
                               <div class="form-group col-md-6">
                                  <label for="passport_no">{{ __('field_passport_no') }}</label>
                                  <input type="text" class="form-control" name="passport_no" id="passport_no" value="{{ old('passport_no') }}">
                                  <div class="invalid-feedback">
                                     {{ __('required_field') }} {{ __('field_passport_no') }}
                                  </div>
                               </div>
                                <div class="form-group col-md-12">
                                   <label for="remark">{{ __('Remark/Bio') }}</label>
                                   <textarea type="text" class="form-control" name="remarks" id="remarks" value="{{ old('remarks') }}"></textarea>
                                   <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_remarks') }}
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
                    <h3>{{ __('tab_educational_info') }}</h3>
                    <content class="form-step">
                       <!-- Form Start--->
                       <fieldset class="row scheduler-border">
                          <div class="form-group col-md-6">
                             <label for="education_level">{{ __('field_education_level') }}</label>
                             <input type="text" class="form-control" name="education_level" id="education_level" value="{{ old('education_level') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_education_level') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="graduation_academy">{{ __('field_graduation_academy') }}</label>
                             <input type="text" class="form-control" name="graduation_academy" id="graduation_academy" value="{{ old('graduation_academy') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_graduation_academy') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="year_of_graduation">{{ __('field_year_of_graduation') }}</label>
                             <input type="text" class="form-control autonumber" name="year_of_graduation" id="year_of_graduation" value="{{ old('year_of_graduation') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_year_of_graduation') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="graduation_field">{{ __('field_graduation_field') }}</label>
                             <input type="text" class="form-control" name="graduation_field" id="graduation_field" value="{{ old('graduation_field') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_graduation_field') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="experience">{{ __('field_experience') }}</label>
                             <textarea class="form-control" name="experience" id="experience">{{ old('experience') }}</textarea>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_experience') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="university">{{ __('university') }}</label>
                             <textarea class="form-control" name="payload[university]" id="university">{{ old('university') }}</textarea>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('university') }}
                             </div>
                          </div>
                          <div class="form-group col-md-3">
                             <label for="hall_ticket_no">{{ __('field_hall_ticket_no') }}</label>
                             <input type="number" class="form-control" name="payload[hall_ticket_no]" id="hall_ticket_no" value="{{ old('payload[hall_ticket_no]') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_hall_ticket_no') }}
                             </div>
                          </div>
                          <div class="form-group col-md-3">
                             <label for="year_of_passing">{{ __('field_year_of_passing') }}</label>
                             <input type="month" class="form-control" name="payload[year_of_passing]" id="year_of_passing" value="{{ old('payload[year_of_passing]') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_year_of_passing') }}
                             </div>
                          </div>
                          <div class="form-group col-md-3">
                             <label for="mark">{{ __('field_marks') }}</label>
                             <input type="text" class="form-control" name="payload[marks]" id="marks" value="{{ old('payload[marks]') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_marks') }}
                             </div>
                          </div>
                          <div class="form-group col-md-3">
                             <label for="percenteage">{{ __('field_percenteage') }}</label>
                             <input type="number" name="payload[percenteage]" step="0.01" min="0" max="100" id="percenteage" value="{{old('payload[percenteage]')  }}"class="form-control">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_percenteage') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="institution">{{ __('field_institution') }}</label>
                             <input type="text" class="form-control" name="payload[institution]" id="institution" value="{{ old('payload[institution]') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_institution') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="grade">{{ __('Grade') }}</label>
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
                          <div class="form-group col-md-12">
                             <label for="note">{{ __('field_note') }}</label>
                             <textarea class="form-control" name="note" id="note">{{ old('note') }}</textarea>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_note') }}
                             </div>
                          </div>
                       </fieldset>
                       <!-- Form End--->
                    </content>
                    {{--Experience tab  --}}
                    <h3>{{ __('Experience Details') }}</h3>
                    <content>
                       <fieldset class="row scheduler-border">
                          <div class="form-group col-md-4">
                             <label for="type">{{ __('Type') }} <span>*</span></label>
                             <select class="form-control" name="type" id="type">
                                <option value="">{{ __('select') }}</option>
                                @foreach ($types as $key => $types)
                                <option value="{{$key}}">{{$types['label']}}</option>
                                @endforeach
                             </select>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_subject') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="subject">{{ __('field_subject') }} <span>*</span></label>
                             <input type="text" class="form-control " name="subject" id="subject" value="{{ old('subject') }}" required>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_subject') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="organization">{{ __('field_organization') }} <span>*</span></label>
                             <input type="text" class="form-control " name="organization" id="organization" value="{{ old('organization') }}" required>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_organization') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="form_date">{{ __('field_form_date') }} </label>
                             <input type="date" class="form-control " name="form_date" id="form_date" value="{{ old('form_date') }}" >
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_form_date') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="to_date">{{ __('field_to_date') }} </label>
                             <input type="date" class="form-control " name="to_date" id="to_date" value="{{ old('to_date') }}" >
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_to_date') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="remark">{{ __('field_remark') }} </label>
                             <input type="text" class="form-control " name="remark" id="remark" value="{{ old('remark') }}" >
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_remark') }}
                             </div>
                          </div>
                       </fieldset>
                       <fieldset class="row scheduler-border">
                          <legend>{{ __('Certificate') }}</legend>
                          <div class="form-group col-md-4">
                             <label for="name">{{ __('field_name') }} </label>
                             <input type="text" class="form-control " name="name" id="name" value="{{ old('name') }}" >
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_name') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="certificate_no">{{ __('field_certificate_no') }} </label>
                             <input type="number" class="form-control " name="certificate_no" id="certificate_no" value="{{ old('certificate_no') }}" >
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_certificate_no') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="completion_date">{{ __('field_completion_date') }} </label>
                             <input type="date" class="form-control " name="completion_date" id="completion_date" value="{{ old('completion_date') }}" >
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_completion_date') }}
                             </div>
                          </div>
                          <div class="form-group col-md-12">
                             <label for="remark">{{ __('field_remark') }} </label> 
                             <textarea class="form-control" name="remark" id="remark">{{ old('remark') }}</textarea>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_name') }}
                             </div>
                          </div>
                       </fieldset>
                    </content>
                    {{--Experience tab end --}}
                    <h3>{{ __('tab_payroll_details') }}</h3>
                    <content class="form-step">
                       <!-- Form Start--->
                       <fieldset class="row scheduler-border">
                          <div class="form-group col-md-4">
                             <label for="contract_type">{{ __('field_contract_type') }} <span>*</span></label>
                             <select class="form-control" name="contract_type" id="contract_type" required>
                                <option value="">{{ __('select') }}</option>
                                <option value="1" @if( old('contract_type') == 1 ) selected @endif>{{ __('contract_type_full_time') }}</option>
                                <option value="2" @if( old('contract_type') == 2 ) selected @endif>{{ __('contract_type_part_time') }}</option>
                             </select>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_contract_type') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="work_shift">{{ __('field_work_shift') }} <span>*</span></label>
                             <select class="form-control" name="work_shift" id="work_shift" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach($work_shifts as $shift )
                                <option value="{{ $shift->id }}" @if( old('work_shift') == $shift->id ) selected @endif>{{ $shift->title }}</option>
                                @endforeach
                             </select>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_work_shift') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="salary_type">{{ __('field_salary_type') }} <span>*</span></label>
                             <select class="form-control" name="salary_type" id="salary_type" required>
                                <option value="">{{ __('select') }}</option>
                                <option value="1" @if( old('salary_type') == 1 ) selected @endif>{{ __('salary_type_fixed') }}</option>
                                <option value="2" @if( old('salary_type') == 2 ) selected @endif>{{ __('salary_type_hourly') }}</option>
                             </select>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_salary_type') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="basic_salary">{{ __('salary_type_hourly') }} / {{ __('salary_type_fixed') }} {{ __('field_salary') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                             <input type="text" class="form-control autonumber" name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}" required>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('salary_type_hourly') }} / {{ __('salary_type_fixed') }} {{ __('field_salary') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="epf_no">{{ __('field_epf_no') }}</label>
                             <input type="text" class="form-control" name="epf_no" id="epf_no" value="{{ old('epf_no') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_epf_no') }}
                             </div>
                          </div>
                       </fieldset>
                       <!-- Form End--->
                    </content>
                    <h3>{{ __('tab_bank_info') }}</h3>
                    <content class="form-step">
                       <!-- Form Start--->
                       <fieldset class="row scheduler-border">
                          <div class="form-group col-md-4">
                             <label for="bank_account_name">{{ __('field_bank_account_name') }}</label>
                             <input type="text" class="form-control" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_bank_account_name') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="bank_account_no">{{ __('field_bank_account_no') }}</label>
                             <input type="text" class="form-control autonumber" name="bank_account_no" id="bank_account_no" value="{{ old('bank_account_no') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_bank_account_no') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="bank_name">{{ __('field_bank_name') }}</label>
                             <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ old('bank_name') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_bank_name') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="ifsc_code">{{ __('field_ifsc_code') }}</label>
                             <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_ifsc_code') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="bank_brach">{{ __('field_bank_branch') }}</label>
                             <input type="text" class="form-control" name="bank_brach" id="bank_brach" value="{{ old('bank_brach') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_bank_branch') }}
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label for="tin_no">{{ __('field_tin_no') }}</label>
                             <input type="text" class="form-control" name="tin_no" id="tin_no" value="{{ old('tin_no') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_tin_no') }}
                             </div>
                          </div>
                       </fieldset>
                       <!-- Form End--->
                    </content>
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
                          <div class="form-group col-md-6">
                             <label for="resume">{{ __('field_resume') }}</label>
                             <input type="file" class="form-control" name="resume" id="resume" value="{{ old('resume') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_resume') }}
                             </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label for="joining_letter">{{ __('field_joining_letter') }}</label>
                             <input type="file" class="form-control" name="joining_letter" id="joining_letter" value="{{ old('joining_letter') }}">
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_joining_letter') }}
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
    }(jQuery));
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#marital_status').click(function() {
            if ($(this).val() == '1') { // Check if "Single" is selected
                $('#marriage_date').prop('disabled', true); // Disable the input
            } else {
                $('#marriage_date').prop('disabled', false); // Enable the input
            }
        });
    });
    </script>
     {{-- Permanent --}}
    <script type="text/javascript">
      "use strict";
        $("#permanent_country").on('change',function(e){
          e.preventDefault();
          var permanentProvince=$("#permanent_province");
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:'POST',
            url: "{{ route('filter-province') }}",
            data:{
              _token:$('input[name=_token]').val(),
              country:$(this).val()
            },
            success:function(response){
                // var jsonData=JSON.parse(response);
                $('option', permanentProvince).remove();
                console.log(response);
                $('#permanent_province').append('<option value="">{{ __("select") }}</option>');
                $.each(response, function(){
                  $('<option/>', {
                    'value': this.id,
                    'text': this.title
                  }).appendTo('#permanent_province');
                });
              }
      
          });
        });
        $("#permanent_province").on('change',function(e){
          e.preventDefault();
          var permanentDistrict=$("#permanent_district");
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:'POST',
            url: "{{ route('filter-district') }}",
            data:{
              _token:$('input[name=_token]').val(),
              province:$(this).val()
            },
            success: function(response) {
              $('option', permanentDistrict).remove();
              $('#permanent_district').append('<option value="">{{ __("select") }}</option>');
    
              $.each(response, function() {
                  var option = $('<option/>', {
                      'value': this.id,
                      'text': this.title
                  });
                  if (typeof permanent_address !== 'undefined') {
                      if (this.id == permanent_address.city_id) {
                          option.attr('selected', 'selected');
                      }
                  }
    
                  option.appendTo('#permanent_district');
              });
            }
          
          });
        });
    </script>
    {{-- Present --}}
    <script type="text/javascript">
      "use strict";
      $("#present_country").on('change',function(e){
      e.preventDefault();
      var permanentProvince=$("#present_province");
    
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{ route('filter-province') }}",
        data:{
          _token:$('input[name=_token]').val(),
          country:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', permanentProvince).remove();
            console.log(response);
            $('#present_province').append('<option value="">{{ __("select") }}</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('#present_province');
            });
          }
    
      });
      });
      $("#present_province").on('change',function(e){
        e.preventDefault();
          var presentDistrict=$("#present_district");
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:'POST',
            url: "{{ route('filter-district') }}",
            data:{
              _token:$('input[name=_token]').val(),
              province:$(this).val(),
            },
            success: function(response) {
              $('option', presentDistrict).remove();
              $('#present_district').append('<option value="">{{ __("select") }}</option>');
    
              $.each(response, function() {
                  var option = $('<option/>', {
                      'value': this.id,
                      'text': this.title
                  });
                  if (typeof permanent_address !== 'undefined') {
                      if (this.id == permanent_address.city_id) {
                          option.attr('selected', 'selected');
                      }
                  }
                  option.appendTo('#present_district');
              });
            }
          });
      });
    </script>
    
@endsection