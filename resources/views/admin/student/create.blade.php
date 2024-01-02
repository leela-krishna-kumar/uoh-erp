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
    .tab-btn.active{
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
@php
  $tabs = [
      ['name' => 'Basics Info','route' => route($route.'.create') ],
      ['name' => 'Educational Info','route' => '#' ],
      ['name' => 'Documents Info','route' => '#' ],
      ['name' => 'Banks Info','route' => '#' ],
   ];
@endphp 
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
               <div class="card-block">
                  @foreach ($tabs as $tab)
                    <span @if(route($route.'.create') != $tab['route']) title="Please fill basic info form first" @endif>
                      <a href="{{ $tab['route'] }}" class="btn tab-btn {{ route($route.'.create') != $tab['route'] ? 'disabled' : 'active' }}">{{$loop->iteration}}. {{ $tab['name'] }}</a>
                    </span>
                  @endforeach
               </div>
               <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                  @csrf
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
                            <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                            <input type="text" minlength="10" maxlength="10" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" required>
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
                           <label for="student_id">{{ __('field_student_id') }} <span>*</span></label>
                           <input min="0" type="number" class="form-control" name="student_id" id="student_id" value="{{ old('student_id') }}" required>
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_student_id') }}
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
                            <label for="mother_tongue">{{ __('mother_tongue') }}</label>
                            <select class="form-control" name="mother_tongue" id="mother_tongue">
                               <option value="">{{ __('select') }}</option>
                               @foreach ($mother_tongues as $key => $mother_tongue)
                                 <option value="{{$mother_tongue->id}}">{{$mother_tongue->name}}</option>
                               @endforeach
                            </select>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_national_id') }}
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
                            <label for="nationality">{{ __('field_nationality') }}</label>
                            <input type="text" class="form-control" name="nationality" id="nationality" value="{{ old('nationality') }}">
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_nationality') }}
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
                            <label for="admission_no">{{ __('field_admission_no') }} <span>*</span></label>
                            <input type="text" class="form-control" name="admission_no" id="admission_no" value="{{ old('admission_no') }}" required>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_admission_no') }}
                            </div>
                         </div>
                         <!-- <div class="form-group col-md-4">
                            <label for="roll_no">{{ __('field_roll_no') }} </label>
                            <input type="text" class="form-control" name="roll_no" id="roll_no" value="{{ old('roll_no') }}" >
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_roll_no') }}
                            </div>
                         </div> -->
                        
                         <div class="form-group col-md-4">
                            <label for="distance_from_residence">{{ __('field_distance_from_residence') }}</label>
                            <input type="text" class="form-control" name="distance_from_residence" id="distance_from_residence" value="{{ old('distance_from_residence') }}" >
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_distance_from_residence') }}
                            </div>
                         </div>
                         <div class="form-group col-md-4">
                            <label for="phc">{{ __('field_phc') }} <span>*</span></label>
                            <select class="form-control" name="phc" id="phc" required>
                               <option value="">{{ __('select') }}</option>
                               <option value="1" @if( old('phc') == 1 ) selected @endif>{{ __('Yes') }}</option>
                               <option value="2" @if( old('phc') == 2 ) selected @endif>{{ __('No') }}</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="phc" id="phc" value="{{ old('phc') }}"> -->
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_phc') }}
                            </div>
                         </div>
                         <div class="form-group col-md-4">
                            <label for="user_category_id">{{ __('field_category') }} <span>*</span></label>
                            <select name="user_category_id" id="" class="form-control select2" required>
                               <option value="" readonly>Select Category</option>
                               @foreach ($user_categories as $user_category)
                               <option value="{{$user_category->id}}">{{$user_category->name}}</option>
                               @endforeach
                            </select>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_category') }}
                            </div>
                         </div>
                         <div class="form-group col-md-4">
                            <label for="caste">{{ __('Caste') }} <span>*</span></label>
                            <select name="caste" id="" class="form-control select2" required>
                               <option value="" readonly>Select Caste</option>
                               @foreach ($castes as $caste)
                               <option value="{{$caste->id}}">{{$caste->name}}</option>
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
                               <option value="{{$seat_type->id}}">{{$seat_type->name}}</option>
                               @endforeach
                            </select>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_seat_type') }}
                            </div>
                         </div>
                         <div class="form-group col-md-4">
                            <label for="identification_marks">{{ __('field_identification_marks') }} </label>
                            <input type="text" class="form-control"  name="identification_marks" id="tags" value="{{ old('identification_marks') }}" >
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
                            <input type="month" class="form-control" name="academic_year_from" id="academic_year_from" value="{{now()->format('Y-m')}}" required>
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
                            <label for="pincode">{{ __('Pincode') }}<span>*</span></label>
                            <input type="number" class="form-control" min="0" maxlength="6" name="present_pincode" id="present_pincode" value="{{ old('present_pincode') }}" required>
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
                            <label for="present_address_1">{{ __('field_address_line1') }}<span>*</span></label>
                            <input required type="text" class="form-control" name="present_address_1" id="present_address_1" value="{{ old('present_address_1') }}">
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_address_line1') }}
                            </div>
                         </div>
                         <div class="form-group col-md-12">
                            <label for="present_address">{{ __('field_address_line2') }}</label>
                            <input type="text" class="form-control" name="present_address_2" id="present_address_2" value="{{ old('present_address_2') }}">
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
                            <input type="number" required class="form-control" name="permanent_pincode" min="0" maxlength="6" id="permanent_pincode" value="{{ old('permanent_pincode') }}">
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
                            <input type="text" class="form-control" name="permanent_address_1" id="permanent_address_1" value="{{ old('permanent_address_1') }}" required>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_address_line1') }}
                            </div>
                         </div>
                         <div class="form-group col-md-12">
                            <label for="permanent_address_2">{{ __('field_address_line2') }}</label>
                            <input type="text" class="form-control" name="permanent_address_2" id="permanent_address_2" value="{{ old('permanent_address_2') }}">
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_address_line2') }}
                            </div>
                         </div>
                      </fieldset>
                   </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary submit-btn">Next <i class="fas fa-arrow-right mr-2"></i></button>
                  </div>
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
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
   
    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>
    {{-- Permanent --}}
    <script src="{{ asset('dashboard/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
    <script type="text/javascript">
      "use strict";
         $('#tags').tagsinput('items');
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