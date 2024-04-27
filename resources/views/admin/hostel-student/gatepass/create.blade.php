@extends('admin.layouts.master')
@section('title', $title)
@section('content')

    <!-- Start Content-->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $title }} {{ __('list') }}</h5>
                        </div>
                        <div class="card-block">
                            {{-- @can($access . '-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan --}}

                            <a href="{{ route($route . '.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i>
                                {{ __('btn_refresh') }}</a>
                        </div>

                        <div class="card-block">
                            <div class="row">
                                <!-- Left side (Form) -->
                                <div class="col-md-6">
                                    <form class="needs-validation" novalidate method="get"
                                        action="{{ route($route . '.create') }}">
                                        <div class="row gx-2">
                                            <div class="form-group col-md-6">
                                                <label for="hostel">Student Roll No <span>*</span></label>
                                                <input type="text" class="form-control" name="search_roll"
                                                    id="search_roll" required value="">
                                                <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_hostel') }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button type="submit" class="btn btn-info btn-filter"><i
                                                        class="fas fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Right side (Table Data) -->
                                @if (isset($row))
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Student Information For : {{ $selected_search_roll }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Student Name:</strong> {{ @$row->first_name }}
                                                        {{ @$row->last_name }}</td>
                                                    <td><strong>Program:</strong> {{ @$row->program->title ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Batch:</strong> {{ @$row->category->name ?? '' }}</td>
                                                    <td><strong>Phone:</strong> {{ $row->phone ?? '' }}</td>
                                                </tr>
                                                @php
                                                    if (isset($row->hostelRoom)) {
                                                        $hostel = \App\Models\Hostel::find($row->hostelRoom->hostel_id);
                                                        $hostel_room = \App\Models\HostelRoom::find(
                                                            $row->hostelRoom->hostel_room_id,
                                                        );
                                                    }
                                                @endphp

                                                <tr>
                                                    <td><strong>Hostel: </strong> {{ @$hostel->name ?? '' }}</td>
                                                    <td><strong>Room: </strong> {{ $hostel_room->name ?? '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- End Content-->

    @if (isset($row))
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

                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                       @csrf
                       <div class="row">

                        <div class="col-md-12">
                           <fieldset class="row scheduler-border">
                            @if (isset($row->hostelRoom))
                            <input type="hidden" name="student_id" class="student_id"value="{{ $row->id ?? '' }}">
                            <input type="hidden" name="hostel_id" class="hostel_id"value="{{ $row->hostelRoom->hostel_id ?? '' }}">
                            <input type="hidden" name="hostel_name" class="hostel_name"value="{{ $hostel->name ?? '' }}">
                            <input type="hidden" name="hostel_room_id" class="hostel_room_id"value="{{ $row->hostelRoom->hostel_room_id ?? '' }}">
                            <input type="hidden" name="hostel_room_name" class="hostel_room_name"value="{{$hostel_room->name ?? '' }}">
                            @endif
                            <div class="form-group col-md-6">
                                <label for="pass_type">Pass Type <span>*</span></label>
                                <select class="form-control" name="pass_type" id="pass_type" required>
                                   <option value="">{{ __('select') }}</option>
                                   <option value="1" @if( old('pass_type') == 1 ) selected @endif>General pass</option>
                                   <option value="2" @if( old('pass_type') == 2 ) selected @endif>Home out going pass</option>
                                   {{-- <option value="3" @if( old('pass_type') == 3 ) selected @endif>{{ __('gender_other') }}</option> --}}
                                </select>
                                <div class="invalid-feedback">
                                   {{ __('required_field') }} Pass Type
                                </div>
                             </div>
                              <div class="form-group col-md-6">
                                 <label for="purpose">Purpose of Out Going <span>*</span></label>
                                 <input type="text" class="form-control" name="purpose" id="purpose" value="{{ old('purpose') }}" required>
                                 <div class="invalid-feedback">
                                    {{ __('required_field') }} purpose
                                 </div>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="out_date">Out Date <span>*</span></label>
                                <input type="date" class="form-control date" name="out_date" id="out_date" value="" required >
                                <div class="invalid-feedback">
                                   {{ __('required_field') }} Out Date
                                </div>
                             </div>
                              <div class="form-group col-md-6">
                                <label for="out_time">Out Time <span>*</span></label>
                                <input type="time" class="form-control time" name="out_time[]" id="out_time" >

                                <div class="invalid-feedback">
                                {{ __('required_field') }} Out Time
                                </div>
                            </div>
                            <div class="form-group col-md-6" id="expected_date_field">
                                <label for="expected_date">Expected Date </label>
                                <input type="date" class="form-control date" name="expected_date" id="expected_date" value="">
                                <div class="invalid-feedback">
                                   {{ __('required_field') }} Expected Date
                                </div>
                             </div>
                              <div class="form-group col-md-6" id="expected_time_field">
                                <label for="expected_time">Expected Time </label>
                                <input type="time" class="form-control time" name="expected_time[]" id="expected_time" >

                                <div class="invalid-feedback">
                                {{ __('required_field') }} Expected Time
                                </div>
                            </div>
                            <div class="form-group col-md-6" id="accompained_field">
                                <label for="accompained">Accompained By/Self </label>
                                <input type="text" class="form-control" name="accompained" id="accompained" value="{{ old('accompained') }}" >
                                <div class="invalid-feedback">
                                   {{ __('required_field') }} Accompained
                                </div>
                             </div>

                           </fieldset>
                        </div>
                     </div>
                     <div class="row">
                       <div class="col-md-12">
                         <button type="submit" class="btn btn-primary submit-btn">Save <i class="fas fa-arrow-right mr-2"></i></button>
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

     @endif
<script>
 $(document ).ready(function() {
        document.getElementById('expected_date_field').style.display = 'none';
        // document.getElementById('expected_time_field').style.display = 'none';
        document.getElementById('accompained_field').style.display = 'none';

    });
    $('#pass_type').on('change',function(){
            var selectedValue = this.value;
        if (selectedValue == "2"){
            document.getElementById('expected_date_field').style.display = 'block';
            // document.getElementById('expected_time_field').style.display = 'block';
            document.getElementById('accompained_field').style.display = 'block';
        }else {
            document.getElementById('expected_date_field').style.display = 'none';
            // document.getElementById('expected_time_field').style.display = 'none';
            document.getElementById('accompained_field').style.display = 'none';

        }

    })
</script>
@endsection
