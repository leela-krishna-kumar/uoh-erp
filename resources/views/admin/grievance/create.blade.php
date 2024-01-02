@extends('admin.layouts.master')
@section('title', $title)

@section('content')

<!-- Start Content-->
{{-- <div class="main-body">
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
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                      <div class="wizard-sec-bg">
                          @csrf
                            <!-- Form Start --> 
                        <fieldset class="row scheduler-border">
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="title">{{ __('Title') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value=""required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="image">{{ __('Image') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                                    <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}">
    
                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_photo') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="semester_id">{{ __('Semester') }} <span>*</span></label>
                                    <select class="form-control select2" name="semester_id" id="semester_id" required>
                                        <option readonly value="">{{ __('Select Semester ') }}</option>
                                        @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->title }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="switch d-inline m-r-10">
                                        <label>{{ __('Is published') }}</label>
                                        <input type="checkbox" id="is_published" name="is_published" value="1">
                                        <label for="is_published" class="cr"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="description">{{ __('Description') }}<span>*</span></label>
                                    <textarea  type="text" name="description" id="description" class="form-control" rows="10" required></textarea>
                                </div>
                            </div>
                        </fieldset>
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
</div> --}}
<!-- End Content-->

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
                                @include('common.inc.ecourse_search_filter')
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
                                                        #
                                                    </th>
                                                    <th>{{ __('field_student_id') }}</th>
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
                                                            <input type="checkbox"onclick="onlyOne(this)" name="student_id" id="checkbox-{{$row->id}}" value="{{$row->student_id}}">
                                                            <label for="checkbox-{{ $row->id }}" class="cr"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.student.show', $row->student->id) }}">
                                                        #{{ $row->student->student_id ?? '' }}
                                                        </a>
                                                    </td>
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
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="title">{{ __('Title') }} <span>*</span></label>
                                                        <input type="text" class="form-control" name="title" id="title" value=""required>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="image">{{ __('Image') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                                                        <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}">
                        
                                                        <div class="invalid-feedback">
                                                        {{ __('required_field') }} {{ __('field_photo') }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <div class="switch d-inline m-r-10">
                                                            <label>{{ __('Is published') }}</label>
                                                            <input type="checkbox" id="is_published" name="is_published" value="1">
                                                            <label for="is_published" class="cr"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="description">{{ __('Description') }}<span>*</span></label>
                                                        <textarea  type="text" name="description" id="description" class="form-control" rows="10" required></textarea>
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
<script>
  function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('student_id')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}
</script>


@endsection
