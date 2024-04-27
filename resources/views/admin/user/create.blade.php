@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

<style>
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

@php
    $tabs = [
        ['name' => 'Profile Info','route' => route($route.'.create') ],
        ['name' => 'Educational Info','route' => '#' ],
        ['name' => 'Experience Details','route' => '#' ],
        ['name' => 'Payroll Details','route' => '#' ],
        ['name' => 'Bank Info','route' => '#' ],
        ['name' => 'Documents','route' => '#' ],
    ];
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
              <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post">
                @csrf
                <div class="row">
                   <div class="col-md-12">
                      <fieldset class="row scheduler-border">
                         <div class="form-group col-md-4">
                            <label for="staff_id">{{ __('field_staff_id') }} <span>*</span></label>
                            <input type="text" class="form-control autonumber" @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin')) readonly @endif name="staff_id" id="staff_id" value="{{ old('staff_id') }}" required>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_staff_id') }}
                            </div>
                         </div>

                         <div class="form-group col-md-4">
                           <label for="staff_id">AICTE ID<span>*</span></label>
                           <input type="text" class="form-control autonumber" @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin')) readonly @endif name="aicte_id" id="aicte_id" value="{{ old('aicte_id') }}" required>
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_staff_id') }}
                           </div>
                        </div>

                        <div class="form-group col-md-4">
                           <label for="staff_id">JNTU ID <span>*</span></label>
                           <input type="text" class="form-control autonumber" @if((auth()->user()->roles[0]->name != 'Super Admin') && (auth()->user()->roles[0]->name != 'admin')) readonly @endif name="jntu_id" id="jntu_id" value="{{ old('jntu_id') }}" required>
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
                            <input type="text" class="form-control" minlength="10" maxlength="10" name="phone" id="phone" value="{{ old('phone') }}" required>
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
                         {{-- <div class="form-group col-md-6">
                           <label for="national_id">{{ __('field_national_id') }}</label>
                           <input type="text" class="form-control" name="national_id" id="national_id" value="{{ old('national_id') }}">
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_national_id') }}
                           </div>
                        </div> --}}

                        <div class="form-group col-md-6">
                           <label for="national_id">Aadhar Number</label>
                           <input type="number" class="form-control" name="aadhar_no"  value="">

                           {{-- <div class="invalid-feedback">
                             {{ __('required_field') }} {{ __('field_national_id') }}
                           </div> --}}
                       </div>

                       <div class="form-group col-md-6">
                         <label for="national_id">Pan Number</label>
                         <input type="text" class="form-control" name="pan" id="pan" value="">

                         {{-- <div class="invalid-feedback">
                           {{ __('required_field') }} {{ __('field_national_id') }}
                         </div> --}}
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
                               <option value="{{ $category->id }}" @if ($key == 0) selected @endif>{{ $category->name }}</option>
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
                               <option value="{{ $category->id }}" @if ($key == 0) selected @endif>{{ $category->name }}</option>
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
    {{-- Present --}}

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
     {{-- Permanent --}}
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