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
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-block">
                        <div class="d-flex">
                            <div>
                                <label for="title" class="form-label">{{ __('field_faculty') }} :  </label> 
                            </div>
                            <div class="ms-1">
                                <h5>{{ @$row->faculty->title }}</h5>
                            </div>
                        </div>
                      <div class="row">
                        <!-- Form Start -->
                        {{-- <div class="form-group">
                            <label for="faculty" class="form-label">{{ __('field_faculty') }} <span>*</span></label>
                            <select class="form-control" name="faculty_id" disabled>
                                <option value="" readonly>Select</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}"@if($row->faculty_id == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_faculty') }}
                            </div>
                        </div> --}}
                    <div class="form-group col-md-6">
                        <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_title') }}
                        </div>
                    </div>

                    <div class="form-group  col-md-6">
                        <label for="regulation" class="form-label">{{ __('field_regulation') }} <span>*</span></label>
                        <select class="form-control"  name="regulation_id">
                            <option   value="" readonly>Select</option>
                            @foreach($regulations as $regulation)
                                <option value="{{ $regulation->id }}" @if($regulation->id == $row->regulation_id) selected @endif>{{ $regulation->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_regulation') }}
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="start_date" class="form-label">{{ __('field_start_date') }} <span>*</span></label>
                        <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ $row->start_date }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_start_date') }}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="end_date" class="form-label">{{ __('field_end_date') }} <span>*</span></label>
                        <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $row->end_date }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_end_date') }}
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="status" class="form-label">{{ __('select_status') }}</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" @if( $row->status == 1 ) selected @endif>{{ __('status_active') }}</option>
                            <option value="0" @if( $row->status == 0 ) selected @endif>{{ __('status_inactive') }}</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="program">{{ __('field_assign') }} {{ __('field_program') }} <span>*</span></label><br/>
                        @if(@$row->faculty->programs->count() > 0)
                            @foreach(@$row->faculty->programs as $key => $program)
                                <br/>
                                <div class="checkbox d-inline">
                                    <input type="checkbox" name="programs[]" id="program-{{ $key }}-{{ $row->id }}" value="{{ $program->id }}"
                                    @foreach($row->programs as $selected_program)
                                        @if($selected_program->id == $program->id) checked @endif 
                                    @endforeach>
                                    <label for="program-{{ $key }}-{{ $row->id }}" class="cr">{{ $program->title }} ({{ $program->shortcode }})</label>
                                </div>
                            @endforeach
                        @else
                            <br>
                            <span class="text-danger">No programs are included in this batch. Create them first</label>  
                        @endif

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_program') }}
                        </div>
                    </div>
                    <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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