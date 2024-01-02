<div class="form-group col-md-4">
  <label for="session">{{ __('field_session') }}<span>*</span></label>
  <select class="form-control session" name="session" id="session" required>
    <option value="">{{ __('select') }}</option>
    @if(isset($sessions))
    @foreach( $sessions->sortByDesc('id') as $session )
    <option value="{{ $session->id }}" >{{ $session->title }}</option>
    @endforeach
    @endif
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_session') }}
  </div>
</div>
<div class="form-group col-md-4">
  <label for="semester">{{ __('field_semester') }} <span>*</span></label>
  <select class="form-control semester" name="semester" id="semester" required>
    <option value="">{{ __('select') }}</option>
		@if(isset($semesters))
		@foreach( $semesters->sortBy('id') as $semester )
			<option value="{{ $semester->id }}"@if($student->semester_id == $semester->id) selected @endif>{{ $semester->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_semester') }}
	</div>
</div>
<div class="form-group col-md-4">
  <label for="section">{{ __('field_section') }} <span>*</span></label>
	<select class="form-control section" name="section" id="section" required>
    <option value="">{{ __('select') }}</option>
		@if(isset($sections))
		@foreach($sections->sortBy('title') as $section)
			<option value="{{ $section->id }}" @if($student->section_id == $section->id) selected @endif>{{ $section->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_section') }}
	</div>
</div>
