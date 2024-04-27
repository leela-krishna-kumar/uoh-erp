@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$publish->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="row">
                              <div class="col-md-12">
                                <fieldset class="row scheduler-border">
                                  <div class="form-group col-md-6">
                                      <label for="name">Title of Book<span>*</span></label>
                                      <input type="text" class="form-control" name="published_book_title" id="name" value="{{ old('published_book_title', $publish->published_book_title) }}" required>

                                      <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_name') }}
                                      </div>
                                  </div>
                                {{-- <div class="form-group col-md-6">
                                    <label for="teacher_name">{{ __('Teacher Name') }}<span>*</span></label>
                                    <select class="form-control" required id="teacher_name" name="teacher_name">
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($users as $status)
                                            <option value="{{ $status['staff_id'] }}" {{ old('staff_id', $publish->staff_id) == $status['staff_id'] ? 'selected' : '' }} data-firstname="{{ $status['first_name'] }}" data-lastname="{{ $status['last_name'] }}" data-staffid="{{ $status['staff_id'] }}">
                                                {{ $status['first_name'] }} {{ $status['last_name'] }} - {{ $status['staff_id'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                
                                {{-- <input type="hidden" name="selected_teacher_first_name" id="selected_teacher_first_name">
                                <input type="hidden" name="selected_teacher_last_name" id="selected_teacher_last_name">
                                <input type="hidden" name="selected_teacher_staff_id" id="selected_teacher_staff_id"> --}}
                                
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Published Chapter Title') }}</label>
                                    <input type="text" class="form-control" name="published_chapter_title" id="name" value="{{ old('published_chapter_title', $publish->published_chapter_title) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="published_book_title">{{ __('Publication Year') }}</label>
                                    <input type="text" class="form-control" value="{{ old('publication_year', $publish->publication_year) }}" name="publication_year" id="datepicker" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('ISBN Number') }}</label>
                                    <input type="text" class="form-control" name="isbn_number" id="name" value="{{ old('isbn_number', $publish->isbn_number) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Publisher Name') }}</label>
                                    <input type="text" class="form-control" name="publisher_name" id="name" value="{{ old('publisher_name', $publish->publisher_name) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Same Affiliating Institute') }}</label>
                                    <select class="form-control" required name="same_affiliating_institute" id="status">
                                        <option value="" {{ old('same_affiliating_institute', $publish->same_affiliating_institute) === '' ? 'selected' : '' }}>{{ __('Select') }}</option>
                                        <option value="1" {{ old('same_affiliating_institute', $publish->same_affiliating_institute) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('same_affiliating_institute', $publish->same_affiliating_institute) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>
    <script>
        $("#datepicker").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose:true
});
    </script>
    {{-- <script>
        document.getElementById('teacher_name').addEventListener('change', function() {
        var selectedIndex = this.selectedIndex;
        var selectedOption = this.options[selectedIndex];
        var selectedFirstName = selectedOption.dataset.firstname;
        var selectedLastName = selectedOption.dataset.lastname;
        var selectedStaffId = selectedOption.dataset.staffid;

        document.getElementById('selected_teacher_first_name').value = selectedFirstName;
        document.getElementById('selected_teacher_last_name').value = selectedLastName;
        document.getElementById('selected_teacher_staff_id').value = selectedStaffId;
    });
    </script> --}}
@endsection