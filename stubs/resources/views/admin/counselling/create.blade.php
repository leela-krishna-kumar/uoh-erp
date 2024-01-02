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
                    <form class="needs-validation" novalidate action="{{route($route.'.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-block">
                                <input type="text" name="faculty" value="{{ $selected_faculty }}" hidden>
                                <input type="text" name="program" value="{{ $selected_program }}" hidden>
                                <input type="text" name="session" value="{{ $selected_session }}" hidden>
                                <input type="text" name="semester" value="{{ $selected_semester }}" hidden>
                                <input type="text" name="section" value="{{ $selected_section }}" hidden>


                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <div class="form-group col-md-12">
                                        <label for="title" class="form-label">{{ __('Choose Student who is submitting counselling') }} <span>*</span></label>
                                        <table class="display table nowrap table-striped table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
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
                                            @foreach($rows as $key => $row)
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-primary d-inline">
                                                            <input type="checkbox"onclick="onlyOne(this)" name="student_id" id="checkbox-{{$row->id}}" value="{{$row->student_id}}">
                                                            <label for="checkbox-{{$row->id}}" class="cr"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.student.show', $row->student->id) }}">
                                                        #{{ $row->student->student_id ?? '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $row->student->name ?? '' }}</td>
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
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <!-- Form Start -->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="manager_ids">{{ __('field_manager') }} <span>*</span></label>
                                                    <select class="form-control" name="manager_ids" id="manager_ids" required>
                                                        <option value="">{{ __('select') }}</option>
                                                        @foreach($managers as $manager)
                                                            <option value="{{ $manager->id }}" @if(old('manager_ids') == $manager->id) selected @endif>{{ $manager->first_name }} {{ $manager->last_name }}</option>
                                                        @endforeach
                                                    </select>
                    
                                                    <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_manager') }}
                                                    </div>
                                                </div>
            
                                                <div class="form-group col-md-12">
                                                    <label for="date" class="form-label">Select Date <span>*</span></label>
                                                    <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required>
                    
                                                    <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_date') }}
                                                    </div>
                                                </div>
            
                                                <div class="form-group col-md-12">
                                                    <label for="time">Select Time <span>*</span></label>
                                                    <input type="time" class="form-control" name="time" id="time" value="{{ old('time') }}" required >
                    
                                                    <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_time') }}
                                                    </div>
                                                </div>
            
                                                <div class="form-group col-md-12">
                                                    <label for="counselling_category_id">{{ __('field_category') }} <span>*</span></label>
                                                    <select class="form-control" name="counselling_category_id" id="counselling_category_id" required>
                                                        <option value="">{{ __('select') }}</option>
                                                        @foreach($counselling_categories as $category)
                                                            <option value="{{ $category->id }}" @if(old('counselling_category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                    
                                                    <div class="invalid-feedback">
                                                    {{ __('required_field') }} {{ __('field_category') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="note">{{ __('field_status') }} <span>*</span></label>
                                                        <select class="form-control" name="status" id="status" required>
                                                            <option value="">{{ __('select') }}</option>
                                                            @foreach ($statuses as $key => $status)
                                                            <option value="{{$key}}"@if($key == 0) selected @endif>{{ $status['label'] }}</option>
                                                            @endforeach
                                                        </select>
                    
                                                        <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('field_status') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="note">{{ __('field_note') }} <span>*</span></label>
                                                        <textarea type="text" class="form-control" name="note" id="note"rows="8" value="{{ old('note') }}" required></textarea>
                    
                                                        <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('field_note') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4"></div>
                                    <!-- Form End -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
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

@yield('sub-script')
<script>
    function onlyOne(checkbox) {
      var checkboxes = document.getElementsByName('student_id')
      checkboxes.forEach((item) => {
          if (item !== checkbox) item.checked = false
      })
}
  </script>

@endsection