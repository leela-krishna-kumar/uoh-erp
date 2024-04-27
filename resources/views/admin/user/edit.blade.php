@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection
<style>
    .bootstrap-tagsinput {
          width: 100%;
    }
    span.tox-statusbar__branding {
          display: none;
    }
    .tab-btn{
      color: #aaa !important;
      background-color: #eee !important;
      border-color: #eee !important;
    }
    .nav-link.active{
      color: #fff !important;
      background-color: #04a9f5 !important;
      border-color: #04a9f5 !important;
    }
    .disabled {
      pointer-events: none;
      opacity: inherit !important; /* or other styling to indicate it's disabled */
    }
    .submit-btn{
      position: fixed;
      bottom: 0;
      right: 15px;
    }
</style>
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
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <div class="card-block">
                      {{-- Nav Link --}}
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher tab-btn @if(!request()->has('active') || request()->get('active') == 'profile') active @endif" data-active="profile" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                            aria-selected="true">1. Profile Info</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher mx-3 tab-btn @if(request()->get('active') == 'educational') active @endif" data-active="educational" id="educational-tab" data-bs-toggle="tab" href="#educational" role="tab" aria-controls="educational"
                            aria-selected="false">2. Educational Info</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher tab-btn @if(request()->get('active') == 'experience') active @endif" data-active="experience" id="experience-tab" data-bs-toggle="tab" href="#user_experience" role="tab" aria-controls="experience"
                            aria-selected="false">3. Experience Details</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher tab-btn mx-3 @if(request()->get('active') == 'payroll') active @endif" data-active="payroll" id="payroll-tab" data-bs-toggle="tab" href="#payroll" role="tab" aria-controls="payroll"
                            aria-selected="false">4. Payroll Details</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher tab-btn @if(request()->get('active') == 'bank') active @endif" data-active="bank" id="bank-tab" data-bs-toggle="tab" href="#bank" role="tab" aria-controls="bank"
                            aria-selected="false">5. Bank Info</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher tab-btn mx-3 @if(request()->get('active') == 'documents') active @endif" data-active="documents" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab" aria-controls="documents"
                            aria-selected="false">6. Documents</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                          <a class="nav-link active-swicher tab-btn mx-3 @if(request()->get('active') == 'research') active @endif" data-active="research" id="research-tab" data-bs-toggle="tab" href="#research" role="tab" aria-controls="research"
                            aria-selected="false">7. Researcher Ids</a>
                        </li>
                        <li class="nav-item" style="padding:10px;">
                            <a class="nav-link active-swicher tab-btn mx-3 @if(request()->get('active') == 'expertise') active @endif" data-active="expertise" id="expertise-tab" data-bs-toggle="tab" href="#expertise" role="tab" aria-controls="expertise"
                              aria-selected="false">8. Expertise</a>
                          </li>
                          <li class="nav-item" style="padding:10px;">
                            <a class="nav-link active-swicher tab-btn mx-3 @if(request()->get('active') == 'professional-body') active @endif" data-active="professional-body" id="professional-body-tab" data-bs-toggle="tab" href="#professional-body" role="tab" aria-controls="professional-body"
                              aria-selected="false">9. Professional Body Membership</a>
                          </li>
                      </ul>

                      {{-- Tab --}}
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade @if(!request()->has('active') || request()->get('active') == 'profile') show active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                                <!-- Form Start -->
                                <div class="row">
                                  <div class="col-md-12">
                                    <fieldset class="row scheduler-border">
                                      <div class="form-group col-md-4">
                                          <label for="staff_id">{{ __('field_staff_id') }} <span>*</span></label>
                                          <input type="text" class="form-control autonumber" name="staff_id" id="staff_id" value="{{ $row->staff_id }}" required @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin')) readonly @endif>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_staff_id') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                        <label for="staff_id">AICTE ID<span>*</span></label>
                                        <input type="text" class="form-control autonumber" @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin'))  @endif name="aicte_id" id="aicte_id" value="{{ auth()->user()->aicte_id }}" required>
                                        <div class="invalid-feedback">
                                           {{ __('required_field') }} {{ __('field_staff_id') }}
                                        </div>
                                     </div>

                                     <div class="form-group col-md-4">
                                        <label for="staff_id">JNTU ID <span>*</span></label>
                                        <input type="text" class="form-control autonumber" @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin'))  @endif name="jntu_id" id="jntu_id" value="{{ auth()->user()->jntu_id }}" required>
                                        <div class="invalid-feedback">
                                           {{ __('required_field') }} {{ __('field_staff_id') }}
                                        </div>
                                     </div>

                                      <div class="form-group col-md-4">
                                          <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                          <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $row->first_name }}" required>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_first_name') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                          <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $row->last_name }}" required>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_last_name') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="father_name">{{ __('field_father_name') }}</label>
                                          <input type="text" class="form-control" name="father_name" id="father_name" value="{{ $row->father_name }}">

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_father_name') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="mother_name">{{ __('field_mother_name') }}</label>
                                          <input type="text" class="form-control" name="mother_name" id="mother_name" value="{{ $row->mother_name }}">

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_mother_name') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                          <select class="form-control" name="gender" id="gender" required>
                                              <option value="">{{ __('select') }}</option>
                                              <option value="1" @if( $row->gender == 1 ) selected @endif>{{ __('gender_male') }}</option>
                                              <option value="2" @if( $row->gender == 2 ) selected @endif>{{ __('gender_female') }}</option>
                                              <option value="3" @if( $row->gender == 3 ) selected @endif>{{ __('gender_other') }}</option>
                                          </select>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_gender') }}
                                          </div>
                                      </div>


                                      {{-- <input type="hidden" name="roles[]" value="{{ $row->id }}"  /> --}}

                                      <div class="form-group col-md-4">
                                          <label for="role">{{ __('field_role') }} <span>*</span></label>
                                          <select class="form-control" name="roles[]" id="role" @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin')) disabled @endif>
                                              <option value="">{{ __('select') }}</option>
                                              @foreach( $roles as $role )
                                              <option value="{{ $role->id }}"
                                                  @foreach($userRoles as $userRole)
                                                      @if($userRole->id == $role->id) selected @endif
                                                  @endforeach
                                              >{{ $role->name }}</option>
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
                                              <option value="{{ $department->id }}" @if($row->department_id == $department->id) selected @endif>{{ $department->title }}</option>
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
                                              <option value="{{ $designation->id }}" @if($row->designation_id == $designation->id) selected @endif>{{ $designation->title }}</option>
                                              @endforeach
                                          </select>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_designation') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                          <input type="date" class="form-control date" name="dob" id="dob" value="{{ $row->dob }}" required>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_dob') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="joining_date">{{ __('field_joining_date') }} <span>*</span></label>
                                          <input type="date" class="form-control date" name="joining_date" id="joining_date" value="{{ $row->joining_date }}" required>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_joining_date') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="ending_date">{{ __('field_ending_date') }}</label>
                                          <input type="date" class="form-control date" name="ending_date" id="ending_date" value="{{ $row->ending_date }}">

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_ending_date') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="email">{{ __('field_primary_email') }} <span>*</span></label>
                                          <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" required>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_primary_email') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                        <label for="email">{{ __('field_secondary_email') }}</label>
                                        <input type="email" class="form-control" name="secondary_email" id="email" value="{{ $row->secondary_email }}">

                                        <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('field_secondary_email') }}
                                        </div>
                                    </div>

                                      <div class="form-group col-md-4">
                                          <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                          <input type="text" class="form-control"minlength="10" maxlength="10" name="phone" id="phone" value="{{ $row->phone }}" required>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_phone') }}
                                          </div>
                                      </div>

                                      <div class="form-group col-md-4">
                                          <label for="emergency_phone">{{ __('field_emergency_phone') }}</label>
                                          <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="{{ $row->emergency_phone }}">

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_emergency_phone') }}
                                          </div>
                                      </div>

                                        <div class="form-group col-md-6">
                                          <label for="marital_status">{{ __('field_marital_status') }}</label>
                                          <select class="form-control" name="marital_status" id="marital_status">
                                              <option value="">{{ __('select') }}</option>
                                              <option value="1" @if( $row->marital_status == 1 ) selected @endif>{{ __('marital_status_single') }}</option>
                                              <option value="2" @if( $row->marital_status == 2 ) selected @endif>{{ __('marital_status_married') }}</option>
                                              <option value="3" @if( $row->marital_status == 3 ) selected @endif>{{ __('marital_status_widowed') }}</option>
                                              <option value="4" @if( $row->marital_status == 4 ) selected @endif>{{ __('marital_status_divorced') }}</option>
                                              <option value="5" @if( $row->marital_status == 5 ) selected @endif>{{ __('marital_status_other') }}</option>
                                          </select>

                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_marital_status') }}
                                          </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="marriage_date">{{ __('Marriage Date') }}</label>
                                          <input type="date" class="form-control" name="marriage_date" id="marriage_date" value="{{ $row->marriage_date }}">
                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_marriage_date') }}
                                          </div>
                                        </div>

                                      <div class="form-group col-md-3">
                                          <label for="device_id">{{ __('Device Id') }}</label>
                                          <input type="text" class="form-control" name="device_id" id="device_id" value="{{ $row->device_id }}">
                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_remarks') }}
                                          </div>
                                      </div>
                                        <div class="form-group col-md-12">
                                          <label for="remark">{{ __('Remark/bio') }}</label>
                                          <input type="text" class="form-control" name="remarks" id="remarks" value="{{ $row->remarks }}">
                                          <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_remarks') }}
                                          </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="blood_group">{{ __('field_blood_group') }}</label>
                                            <select class="form-control" name="blood_group" id="blood_group">
                                                <option value="">{{ __('select') }}</option>
                                                <option value="1" @if( $row->blood_group == 1 ) selected @endif>{{ __('A+') }}</option>
                                                <option value="2" @if( $row->blood_group == 2 ) selected @endif>{{ __('A-') }}</option>
                                                <option value="3" @if( $row->blood_group == 3 ) selected @endif>{{ __('B+') }}</option>
                                                <option value="4" @if( $row->blood_group == 4 ) selected @endif>{{ __('B-') }}</option>
                                                <option value="5" @if( $row->blood_group == 5 ) selected @endif>{{ __('AB+') }}</option>
                                                <option value="6" @if( $row->blood_group == 6 ) selected @endif>{{ __('AB-') }}</option>
                                                <option value="7" @if( $row->blood_group == 7 ) selected @endif>{{ __('O+') }}</option>
                                                <option value="8" @if( $row->blood_group == 8 ) selected @endif>{{ __('O-') }}</option>
                                            </select>

                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_blood_group') }}
                                            </div>
                                        </div>

                                        {{-- <div class="form-group col-md-6">
                                            <label for="national_id">{{ __('field_national_id') }}</label>
                                            <input type="text" class="form-control" name="national_id" id="national_id" value="{{ $row->national_id }}">

                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_national_id') }}
                                            </div>
                                        </div> --}}

                                        <div class="form-group col-md-6">
                                          <label for="national_id">Aadhar Number</label>
                                          <input type="number" class="form-control" name="aadhar_no"  value="{{ $row->aadhar }}">

                                          {{-- <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_national_id') }}
                                          </div> --}}
                                      </div>

                                      <div class="form-group col-md-6">
                                        <label for="national_id">Pan Number</label>
                                        <input type="text" class="form-control" name="pan" id="pan" value="{{ $row->pan }}">

                                        {{-- <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('field_national_id') }}
                                        </div> --}}
                                    </div>

                                    <div class="form-group col-md-6">
                                      <label for="national_id">Driving License Number</label>
                                      <input type="text" class="form-control" name="driving_license_number" id="driving_license_number" value="{{ $row->driving_license_number }}">

                                      {{-- <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_national_id') }}
                                      </div> --}}
                                  </div>
                                  

                                        <div class="form-group col-md-6">
                                            <label for="passport_no">{{ __('field_passport_no') }}</label>
                                            <input type="text" class="form-control" name="passport_no" id="passport_no" value="{{ $row->passport_no }}">

                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_passport_no') }}
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
                                      <input type="number" class="form-control" name="present_pincode" id="present_pincode" value="{{@$permanent_address->payload['pincode']}}">
                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Pincode') }}
                                      </div>
                                  </div>
                                    <div class="form-group col-md-6">
                                      <label for="type">{{ __('Type') }}</label>
                                      <select class="form-control" name="present_type" id="present_type">
                                          <option value="">{{ __('select') }}</option>
                                          @foreach($address_categories as $key => $category)
                                                <option value="{{ @$category->id }}"@if(@$category->id == @$present_address->type) selected @endif>{{ @$category->name }}</option>
                                            @endforeach
                                      </select>

                                      <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('Type') }}
                                      </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="present_address_1">{{ __('field_address1') }}</label>
                                        <input type="text" class="form-control" name="present_address_1" id="present_address_1" value="{{ $present_address && isset($present_address->payload['address_1']) ? $present_address->payload['address_1'] : '' }}">

                                        <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('field_address1') }}
                                        </div>
                                    </div>
                                   <div class="form-group col-md-12">
                                      <label for="present_address">{{ __('Address2') }}</label>
                                      <input type="text" class="form-control" name="present_address_2" id="present_address_2"
                                      value="{{ $present_address && isset($present_address->payload['address_2']) ? $present_address->payload['address_2'] : '' }}" >
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
                                      <input type="text" class="form-control" name="permanent_pincode" id="permanent_pincode" value="{{@$permanent_address->payload['pincode']}}">

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Pincode') }}
                                      </div>
                                  </div>
                                    <div class="form-group col-md-6">
                                      <label for="type">{{ __('Type') }}</label>
                                      <select class="form-control" name="permanent_type" id="permanent_type">
                                          <option value="">{{ __('select') }}</option>
                                          @foreach($address_categories as $key => $category)
                                          <option value="{{ @$category->id }}"@if(@$category->id == @$present_address->type) selected @endif>{{ @$category->name }}</option>
                                      @endforeach
                                      </select>

                                      <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('Type') }}
                                      </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="permanent_address_1">{{ __('field_address1') }}</label>
                                        <input type="text" class="form-control" name="permanent_address_1" id="permanent_address_1" value="{{@$permanent_address->payload['address_1']}}">

                                        <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('field_address1') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="permanent_address_2">{{ __('field_address2') }}</label>
                                        <input type="text" class="form-control" name="permanent_address_2" id="permanent_address_2"  value="{{@$permanent_address->payload['address_2']}}">

                                        <div class="invalid-feedback">
                                          {{ __('required_field') }} {{ __('field_address2') }}
                                        </div>
                                    </div>
                                    </fieldset>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                  </div>
                                </div>
                                <!-- Form End -->
                          </form>
                        </div>
                        <div class="tab-pane fade @if(request()->get('active') == 'educational') show active @endif" id="educational" role="tabpanel" aria-labelledby="educational-tab">
                            @include('admin.user.educational.index')
                        </div>

                        @php
                          use Illuminate\Support\Facades\DB;
                          $experiences = DB::table('experiences')->orderBy('id', 'desc')->where('user_id', auth()->user()->id)->get();
                        @endphp

                        <div class="tab-pane fade @if(request()->get('active') == 'experience') show active @endif" id="user_experience" role="tabpanel" aria-labelledby="experience-tab">
                              @include('admin.user.experience.index', ['experiences' => $experiences])
                        </div>
                        <div class="tab-pane fade @if(request()->get('active') == 'payroll') show active @endif" id="payroll" role="tabpanel" aria-labelledby="payroll-tab">
                            @include('admin.user.payroll.index')
                        </div>

                      <div class="tab-pane fade @if(request()->get('active') == 'bank') show active @endif" id="bank" role="tabpanel" aria-labelledby="bank-tab">
                          @include('admin.user.banks.index')
                      </div>

                      @php
                          $docable_ids = DB::table('docables')->where('docable_id', auth()->user()->id)->pluck('document_id');
                          $documents = DB::table('documents')->whereIn('id', $docable_ids)->select('title', 'attach', 'id')->get();
                      @endphp

                      <div class="tab-pane fade @if(request()->get('active') == 'documents') show active @endif" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                        @include('admin.user.documents.index', ['documents' => $documents])
                      </div>

                        <div class="tab-pane fade @if(request()->get('active') == 'research') show active @endif" id="research" role="tabpanel" aria-labelledby="research-tab">
                          @include('admin.user.research.index')
                       </div>
                       <div class="tab-pane fade @if(request()->get('active') == 'expertise') show active @endif" id="expertise" role="tabpanel" aria-labelledby="expertise-tab">
                            @include('admin.user.expertise.index')
                        </div>
                        <div class="tab-pane fade @if(request()->get('active') == 'professional-body') show active @endif" id="professional-body" role="tabpanel" aria-labelledby="professional-body-tab">
                            @include('admin.user.professional-body.index')
                        </div>
                      </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
      // Update Active on url
        function updateURL(key,val){
            var url = window.location.href;
            var reExp = new RegExp("[\?|\&]"+key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

            if(reExp.test(url)) {
                // update
                var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
                var delimiter = reExp.exec(url)[0].charAt(0);
                url = url.replace(reExp, delimiter + key + "=" + val);
            } else {
                // add
                var newParam = key + "=" + val;
                if(!url.indexOf('?')){url += '?';}

                if(url.indexOf('#') > -1){
                    var urlparts = url.split('#');
                    url = urlparts[0] +  "&" + newParam +  (urlparts[1] ?  "#" +urlparts[1] : '');
                } else {
                    url += "?" + newParam;
                }
            }
            window.history.pushState(null, document.title, url);
        }
        $(document).on('click','.active-swicher',function() {
            var active = $(this).attr('data-active');
            updateURL('active',active);
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
              html += '<div class="form-group col-md-1"><span>*</span></label><input type="hidden" class="form-control" name="documentids[]" id="title" value="" required><div class="invalid-feedback"></div></div>';
              
              html += '</div>';

              $('#newDocument').append(html);
          });

          // remove Field
          $(document).on('click', '#removeDocument', function () {
              $(this).closest('#documentFormField').remove();
          });
      }(jQuery));
    </script>
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
            // $('option', permanentDistrict).remove();
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

  <script>

    // State City Sync
    function getStateAsync(countryId,id) {
        return new Promise((resolve, reject) => {
            var permanentProvince=$("#"+id);
            $.ajax({
                  url: '{{ route("filter-province") }}',
                  method: 'POST',
              data: {
                _token:$('input[name=_token]').val(),
                country: countryId
              },
              success: function (response) {
                $('option', permanentProvince).remove();
                console.log(response);
                $('#'+id).append('<option value="">{{ __("select") }}</option>');
                $.each(response, function(){
                  $('<option/>', {
                    'value': this.id,
                    'text': this.title
                  }).appendTo('#'+id);
                });
                resolve(response)
              },
              error: function (error) {
                reject(error)
              },
            })
        })
    }

    function getCityAsync(stateId,id) {
        if(stateId != ""){
            var permanentDistrict=$("#"+id);
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route("filter-district") }}',
                    method: 'POST',
                    data: {
                        _token:$('input[name=_token]').val(),
                        province:stateId
                    },
                    success: function (response) {
                        // $('option', permanentDistrict).remove();
                        $('#'+id).append('<option value="">{{ __("select") }}</option>');
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
                            option.appendTo('#'+id);
                        });
                    resolve(response)
                    },
                    error: function (error) {
                    reject(error)
                    },
                })
            })
        }
    }

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
            // $('option', presentDistrict).remove();
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

<script>
     // Permanent Address
     var permanent_country = "{{ @$permanent_address->country_id }}";
        var permanent_province = "{{ @$permanent_address->state_id }}";
        var permanent_district = "{{ @$permanent_address->city_id }}";
        $(document).ready(function(){
            if(permanent_province){
              setTimeout(() => {
                    getStateAsync([permanent_country],'permanent_province').then(function(data){
                        $('#permanent_province').val(permanent_province).change();
                        $('#permanent_province').trigger('change');
                    });
              }, 500);
            }

            if(permanent_district){
                setTimeout(() => {
                    getCityAsync(permanent_province,'permanent_district').then(function(data){
                        $('#permanent_district').val(permanent_district).change();
                        $('#permanent_district').trigger('change');
                    });
                }, 1000);
            }
        });

      var present_country = "{{ @$present_address->country_id }}";
      var present_province = "{{ @$present_address->state_id }}";
      var present_district = "{{ @$present_address->city_id }}";
      $(document).ready(function(){
          if(present_province){
            setTimeout(() => {
                  getStateAsync([present_country],'present_province').then(function(data){
                      $('#present_province').val(present_province).change();
                      $('#present_province').trigger('change');
                  });
            }, 500);
          }

          if(present_district){
              setTimeout(() => {
                  getCityAsync(present_province,'present_district').then(function(data){
                      $('#present_district').val(present_district).change();
                      $('#present_district').trigger('change');
                  });
              }, 1000);
          }
      });
    // State City Sync
    function getStateAsync(countryId,id) {
        return new Promise((resolve, reject) => {
            var permanentProvince=$("#"+id);
            $.ajax({
                  url: '{{ route("filter-province") }}',
                  method: 'POST',
              data: {
                _token:$('input[name=_token]').val(),
                country: countryId
              },
              success: function (response) {
                $('option', permanentProvince).remove();
                console.log(response);
                $('#'+id).append('<option value="">{{ __("select") }}</option>');
                $.each(response, function(){
                  $('<option/>', {
                    'value': this.id,
                    'text': this.title
                  }).appendTo('#'+id);
                });
                resolve(response)
              },
              error: function (error) {
                reject(error)
              },
            })
        })
    }

    function getCityAsync(stateId,id) {
        if(stateId != ""){
            var permanentDistrict=$("#"+id);
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route("filter-district") }}',
                    method: 'POST',
                    data: {
                        _token:$('input[name=_token]').val(),
                        province:stateId
                    },
                    success: function (response) {
                        // $('option', permanentDistrict).remove();
                        $('#'+id).append('<option value="">{{ __("select") }}</option>');
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
                            option.appendTo('#'+id);
                        });
                    resolve(response)
                    },
                    error: function (error) {
                    reject(error)
                    },
                })
            })
        }
    }

  </script>
@endsection
