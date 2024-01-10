@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.css') }}">
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
@php
  $documentTypes = App\Models\DocumentType::get();
@endphp
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
                   <h5>{{ __('modal_edit') }} {{ $title }} #{{@$student->id}}</h5>
                </div>
                <div class="card-block">
                   <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                   <a href="{{ route($route.'.edit',[$student->id,'active'=>'basic']) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                </div>
                <div class="card-block">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active-swicher tab-btn @if(!request()->has('active') || request()->get('active') == 'basic') active @endif" data-active="basic" id="basic-tab" data-bs-toggle="tab" href="#basic" role="tab" aria-controls="basic"
                        aria-selected="true">1. Basic Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active-swicher mx-3 tab-btn @if(request()->get('active') == 'educational') active @endif" data-active="educational" id="educational-tab" data-bs-toggle="tab" href="#educational" role="tab" aria-controls="educational"
                        aria-selected="false">2. Educational Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active-swicher tab-btn @if(request()->get('active') == 'documents') active @endif" data-active="documents" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab" aria-controls="documents"
                        aria-selected="false">3. Documents</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active-swicher tab-btn mx-3 @if(request()->get('active') == 'banks') active @endif" data-active="banks" id="banks-tab" data-bs-toggle="tab" href="#banks" role="tab" aria-controls="banks"
                        aria-selected="false">4. Banks</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade @if(!request()->has('active') || request()->get('active') == 'basic') show active @endif" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                      <form class="needs-validation" novalidate action="{{ route($route.'.update', [$student->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-md-12">
                              <fieldset class="row scheduler-border">
                                  <legend>{{ __('tab_basic_info') }}</legend>
                                  <div class="form-group col-md-6">
                                    <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ @$student->first_name }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_first_name') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ @$student->last_name }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_last_name') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                    <input type="text" minlength="10" maxlength="10" class="form-control" name="phone" id="phone" value="{{ @$student->phone }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_phone') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">{{ __('field_email') }} <span>*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ @$student->email }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_email') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="">{{ __('select') }}</option>
                                        <option value="1" @if( $student->gender == 1 ) selected @endif>{{ __('gender_male') }}</option>
                                        <option value="2" @if( $student->gender == 2 ) selected @endif>{{ __('gender_female') }}</option>
                                        <option value="3" @if( $student->gender == 3 ) selected @endif>{{ __('gender_other') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_gender') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                    <input type="date" class="form-control date" name="dob" id="dob" value="{{ @$student->dob }}" required max="{{now()->format('Y-m-d')}}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_dob') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="marital_status">{{ __('field_marital_status') }}</label>
                                    <select class="form-control" name="marital_status" id="marital_status">
                                        <option value="">{{ __('select') }}</option>
                                        <option value="1" @if( $student->marital_status == 1 ) selected @endif>{{ __('marital_status_single') }}</option>
                                        <option value="2" @if( $student->marital_status == 2 ) selected @endif>{{ __('marital_status_married') }}</option>
                                        <option value="3" @if( $student->marital_status == 3 ) selected @endif>{{ __('marital_status_widowed') }}</option>
                                        <option value="4" @if( $student->marital_status == 4 ) selected @endif>{{ __('marital_status_divorced') }}</option>
                                        <option value="5" @if( $student->marital_status == 5 ) selected @endif>{{ __('marital_status_other') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_marital_status') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="blood_group">{{ __('field_blood_group') }}</label>
                                    <select class="form-control" name="blood_group" id="blood_group">
                                        <option value="">{{ __('select') }}</option>
                                        <option value="1" @if( $student->blood_group == 1 ) selected @endif>{{ __('A+') }}</option>
                                        <option value="2" @if( $student->blood_group == 2 ) selected @endif>{{ __('A-') }}</option>
                                        <option value="3" @if( $student->blood_group == 3 ) selected @endif>{{ __('B+') }}</option>
                                        <option value="4" @if( $student->blood_group == 4 ) selected @endif>{{ __('B-') }}</option>
                                        <option value="5" @if( $student->blood_group == 5 ) selected @endif>{{ __('AB+') }}</option>
                                        <option value="6" @if( $student->blood_group == 6 ) selected @endif>{{ __('AB-') }}</option>
                                        <option value="7" @if( $student->blood_group == 7 ) selected @endif>{{ __('O+') }}</option>
                                        <option value="8" @if( $student->blood_group == 8 ) selected @endif>{{ __('O-') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_blood_group') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="mother_tongue">{{ __('mother_tongue') }}</label>
                                    <select class="form-control" name="mother_tongue" id="mother_tongue">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach ($mother_tongues as $key => $mother_tongue)
                                        <option value="{{$mother_tongue->id}}" @if($student->mother_tongue == $mother_tongue->id) selected @endif>{{$mother_tongue->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('mother_tongue') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="religion">{{ __('field_religion') }}</label>
                                    <input type="text" class="form-control" name="religion" id="religion" value="{{ @$student->religion }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_religion') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="nationality">{{ __('field_nationality') }}</label>
                                    <input type="text" class="form-control" name="nationality" id="nationality" value="{{ @$student->nationality }}">
                                    <div class="invalid-feedback">
                                       {{ __('required_field') }} {{ __('field_nationality') }}
                                    </div>
                                 </div>
                                  <div class="form-group col-md-4">
                                    <label for="admission_date">{{ __('field_admission_date') }} <span>*</span></label>
                                    <input type="date" class="form-control date" name="admission_date" id="admission_date" value="{{ @$student->admission_date }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_admission_date') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="admission_no">{{ __('field_admission_no') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="admission_no" id="admission_no" value="{{ @$student->admission_no }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_admission_no') }}
                                    </div>
                                  </div>
                                  <!-- <div class="form-group col-md-4">
                                    <label for="roll_no">{{ __('field_roll_no') }} </label>
                                    <input type="text" class="form-control" name="roll_no" id="roll_no" value="{{ @$student->roll_no }}" >
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_roll_no') }}
                                    </div>
                                  </div> -->
                                 
                                  <div class="form-group col-md-4">
                                    <label for="distance_from_residence">{{ __('field_distance_from_residence') }}</label>
                                    <input type="text" class="form-control" name="distance_from_residence" id="distance_from_residence" value="{{ @$student->distance_from_residence }}" >
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_distance_from_residence') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="phc">{{ __('field_phc') }} <span>*</span></label>
                                    <select class="form-control" name="phc" id="phc" required>
                                        <option value="">{{ __('select') }}</option>
                                        <option value="1" @if( $student->phc == 1 ) selected @endif>{{ __('Yes') }}</option>
                                        <option value="2" @if( $student->phc == 2 ) selected @endif>{{ __('No') }}</option>
                                    </select>
                                    <!-- <input type="text" class="form-control" name="phc" id="phc" value="{{ @$student->phc }}"> -->
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_phc') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="user_category_id">{{ __('field_category') }} <span>*</span></label>
                                    <select name="user_category_id" id="" class="form-control select2" required>
                                        <option value="" readonly>Select Category</option>
                                        @foreach ($user_categories as $user_category)
                                        <option value="{{$user_category->id}}" @if ($user_category->id == @$student->user_category_id) selected @endif>{{$user_category->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_category') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="caste">{{ __('Caste') }} <span></span></label>
                                    <select name="caste" id="" class="form-control select2">
                                       <option value="" readonly>Select Caste</option>
                                       @foreach ($castes as $caste)
                                       <option value="{{$caste->id}}"@if($caste->id == @$student->caste) selected @endif>
                                          {{$caste->name}}
                                      </option>
                                       @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                       {{ __('required_field') }} {{ __('field_caste') }}
                                    </div>
                                 </div>
                                 <div class="form-group col-md-4">
                                    <label for="seat_type_id">{{ __('field_seat_type') }} <span>*</span></label>
                                    <select name="seat_type_id" id="" class="form-control select2" required>
                                      <option value="" readonly>Select Seat Type</option>
                                      @foreach ($seat_types as $seat_type)
                                      <option value="{{$seat_type->id}}" @if($seat_type->id == @$student->seat_type_id) selected @endif>{{$seat_type->name}}</option>
                                      @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_seat_type') }}
                                    </div>
                                 </div>
                                 <div class="form-group col-md-4">
                                    <label for="identification_marks">{{ __('field_identification_marks') }} </label>
                                    <input type="text" class="form-control" name="identification_marks" id="tags" value="{{ @$student->identification_marks }}" >
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_identification_marks') }}
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
                                    <input type="month" class="form-control" name="academic_year_from" id="academic_year_from" value="{{ @$student->academic_year_from }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_first_name') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="academic_year_to">{{ __('field_academic_year_to') }} <span>*</span></label>
                                    <input type="month" class="form-control" name="academic_year_to" id="academic_year_to" value="{{ @$student->academic_year_to }}" required>
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
                                  <legend>{{ __('field_present') }} {{ __('field_address') }}</legend>
                                  @include('common.inc.present_province')
                                  <div class="form-group col-md-6">
                                    <label for="pincode">{{ __('Pincode') }}<span>*</span></label>
                                    <input type="number" class="form-control" name="present_pincode" min="0" id="present_pincode" value="{{ @$present_address->payload['pincode'] }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Pincode') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="type">{{ __('Type') }}<span></span></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($address_categories as $key => $category)
                                        <option value="{{ $category->id }}" @if ($key == 0) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Type') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label for="present_address_1">{{ __('field_address_line1') }}<span>*</span></label>
                                    <input required type="text" class="form-control" name="present_address_1" id="present_address_1" value="{{ @$present_address->payload['address_1'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_address_line1') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label for="present_address">{{ __('field_address_line2') }}</label>
                                    <input type="text" class="form-control" name="present_address_2" id="present_address_2" value="{{ @$present_address->payload['address_2'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_address_line2') }}
                                    </div>
                                  </div>
                              </fieldset>
                            </div>
                            <div class="col-md-6">
                              <fieldset class="row scheduler-border">
                                  <legend>{{ __('field_permanent') }} {{ __('field_address') }}</legend>
                                  @include('common.inc.permanent_province')
                                  <div class="form-group col-md-6">
                                    <label for="permanent_pincode">{{ __('Pincode') }}<span>*</span></label>
                                    <input type="number" required class="form-control" name="permanent_pincode" min="0" id="permanent_pincode" value="{{ @$permanent_address->payload['pincode'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Pincode') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="type">{{ __('Type') }}<span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($address_categories as $key => $category)
                                        <option value="{{ $category->id }}" @if ($key == 0) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Type') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label for="permanent_address_1">{{ __('field_address_line1') }}<span>*</span></label>
                                    <input type="text" class="form-control" name="permanent_address_1" id="permanent_address_1" value="{{ @$permanent_address->payload['address_1'] }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_address_line1') }}
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label for="permanent_address_2">{{ __('field_address_line2') }}</label>
                                    <input type="text" class="form-control" name="permanent_address_2" id="permanent_address_2" value="{{ @$permanent_address->payload['address_2'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_address_line2') }}
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
                      </form>
                      {{-- Guardian Details --}}
                      @include('admin.guardian-detail.index')
                    </div>
                    <div class="tab-pane fade @if(request()->get('active') == 'educational') show active @endif" id="educational" role="tabpanel" aria-labelledby="educational-tab">
                      @include('admin.educational-info.index')
                    </div>
                    <div class="tab-pane fade @if(request()->get('active') == 'documents') show active @endif" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                      @include('admin.documents-info.index')
                    </div>
                    <div class="tab-pane fade @if(request()->get('active') == 'banks') show active @endif" id="banks" role="tabpanel" aria-labelledby="banks-tab">
                      @include('admin.banks-info.index')
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

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
    <script type="text/javascript">
         $('#tags').tagsinput('items');
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
      $('.active-swicher').on('click', function() {
          var active = $(this).attr('data-active');
          updateURL('active',active);
      });
    </script>
{{-- Document Repeater --}}
 <script type="text/javascript">
  (function ($) {
      "use strict";
      // add Field

      var documentTypes = {!! json_encode($documentTypes) !!};

      $(document).on('click', '#addDocument', function () {
          var html = '';
          html += '<hr/>';
          html += '<div id="documentFormField" class="row">';
          html += '<div class="form-group col-md-3"><label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label><input type="text" class="form-control" name="titles[]" id="title" value="{{ old('title') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div></div>';

          html += '<div class="form-group col-md-3"><label for="type" class="form-label">{{ __('field_type') }} <span>*</span></label><select required class="form-control" name="type_ids[]"><option value=""readonly required>Select Document Type</option>';
            
          // Add options for document types
          for (var i = 0; i < documentTypes.length; i++) {
              html += '<option value="' + documentTypes[i].id + '">' + documentTypes[i].name + '</option>';
          }
          
          html += '</select><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_type') }}</div></div>';

          html += '<div class="form-group col-md-3"><label for="document" class="form-label">{{ __('field_document') }} <span>*</span></label><input type="file" class="form-control" name="documents[]" id="document" value="{{ old('document') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_document') }}</div></div>';
          html += '<div class="form-group col-md-3"><button id="removeDocument" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button></div>';
          html += '</div>';

          $('#newDocument').append(html);
      });

      // remove Field
      $(document).on('click', '#removeDocument', function () {
          $(this).closest('#documentFormField').remove();
      });
  }(jQuery));
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
    $(document).ready(function() {
      $('.batch').trigger('change');
      setTimeout(() => {
        $('.program').trigger('change');
      }, 1000);
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

    });
  </script>
@include('common.js.batch_filter')
  {{-- ACADEMIC INFORMATION --}}
  <script>
    // Syns Functions
    function getProgramAsync(facultyId,id) {
        return new Promise((resolve, reject) => {
            var permanentProvince=$("#"+id);
            $.ajax({
                  url: '{{ route("filter-province") }}',
                  method: 'POST',
              data: {
                _token:$('input[name=_token]').val(),
                country: facultyId
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
  </script>
  <script>
    $(document).ready(function() {
        $('#obtain_marks').on('input', function() {
            var obtainMarks = parseFloat($(this).val());
            var totalMarks = parseFloat($('#total_marks').val());

            if (obtainMarks > totalMarks) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').html('{{ __('Obtained marks must be less than total marks.') }}');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').html('{{ __('required_field') }} {{ __('field_obtain_marks') }}');
            }
        });

        $('#total_marks').on('input', function() {
            // Trigger the obtain_marks input to revalidate when total_marks changes
            $('#obtain_marks').trigger('input');
        });
        $('#edit_obtain_marks').on('input', function() {
            var obtainMarks = parseFloat($(this).val());
            var totalMarks = parseFloat($('#edit_total_marks').val());

            if (obtainMarks > totalMarks) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').html('{{ __('Obtained marks must be less than total marks.') }}');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').html('{{ __('required_field') }} {{ __('field_obtain_marks') }}');
            }
        });

        $('#edit_total_marks').on('input', function() {
            // Trigger the obtain_marks input to revalidate when total_marks changes
            $('#edit_obtain_marks').trigger('input');
        });
    });
</script>
@endsection