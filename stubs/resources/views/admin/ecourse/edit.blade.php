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
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit',$row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update',$row->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <fieldset class="row scheduler-border">
                      <div class="col-md-6">
                          <div class="form-group col-md-12">
                              <label for="title">{{ __('Title') }} <span>*</span></label>
                              <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}"required>
                          </div>
                          <div class="form-group col-md-12">
                                <label for="duration">{{ __('Duration') }} ({{ __('In min.') }})<span>*</span></label>
                                <input type="number" class="form-control" name="duration" id="duration" value="{{$row->duration}}"required>
                            </div>
                          <div class="form-group col-md-12">
                              <label for="image">{{ __('Image') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
                              <input type="file" class="form-control" name="image" id="image" value="{{$row->image}}" accept="image/png, image/gif, image/jpeg" />
                              <div class="invalid-feedback"enctype="multipart/form-data">
                              {{ __('required_field') }} {{ __('Image') }}
                              </div>
                          </div>
                          {{-- <div class="form-group col-md-12">
                              <label for="semester_id">{{ __('Semester') }} <span>*</span></label>
                              <select class="form-control" name="semester_id" id="semester_id" >
                                  <option readonly value="">{{ __('Select Semester ') }}</option>
                                  @foreach($semesters as $semester)
                                  <option value="{{ $semester->id }}" @if($semester->id == $row->semester_id) selected @endif>{{ $semester->title }} </option>
                                  @endforeach
                              </select>
                              <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Semester') }}
                                </div>
                          </div> --}}
                          <div class="form-group col-md-12">
                              <div class="switch d-inline m-r-10">
                                  <label>{{ __('Is Published') }}</label>
                                  <input type="checkbox" id="is_published" name="is_published" value="1" @if ($row->is_published == 1) checked @endif>
                                  <label for="is_published" class="cr"></label>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group col-md-12">
                              <label for="description">{{ __('Description') }}<span>*</span></label>
                              <textarea  type="text" name="description" id="description" class="form-control" rows="10" required>{{$row->description}}</textarea>
                          </div>
                      </div>
                  </fieldset>
                    
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