
<div class="form-group col-md-3">
  <label for="batch">{{ __('field_batch') }} <span>*</span></label>
  <select class="form-control batch" name="batch" id="batch" required>
		<option value="">{{ __('select') }}</option>  
		@if(isset($batches))
		@foreach( $batches->sortBy('title') as $batch )
			<option value="{{ $batch->id }}"@if($student->batch_id == $batch->id) selected @endif>{{ $batch->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_faculty') }}
	</div>
</div>
<div class="form-group col-md-3">
  <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
  <select class="form-control faculty" name="faculty" id="faculty" required>
		<option value="">{{ __('select') }}</option>  
		@if(isset($faculties))
		@foreach($faculties->sortBy('title') as $faculty)
			<option value="{{ $faculty->id }}"@if($student->faculty_id == $faculty->id) selected @endif>{{ $faculty->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_faculty') }}
	</div>
</div>
<div class="form-group col-md-3">
  <label for="program">{{ __('field_program') }} <span>*</span></label>
  <select class="form-control program" name="program" id="program" required>
		<option value="">{{ __('select') }}</option>
		@if(isset($programs))
		@foreach( $programs->sortBy('title') as $program )
		<option value="{{ $program->id }}"@if($student->program_id == $program->id) selected @endif>{{ $program->title }}</option>
		@endforeach
		@endif
	</select>

	<div class="invalid-feedback">
		{{ __('required_field') }} {{ __('field_program') }}
	</div>
</div>
<div class="form-group col-md-3">
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
<div class="form-group col-md-3">
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
<div class="form-group col-md-3">
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
<!-- <div class="form-group col-md-3">
  <label for="subject">{{ __('field_subject') }} <span>*</span></label>
  <select class="form-control subject" name="subject" id="subject" required>
    <option value="">{{ __('select') }}</option>
    @if(isset($subjects))
    @foreach( $subjects->sortBy('code') as $subject )
    <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->title }}</option>
    @endforeach
    @endif
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_subject') }}
  </div>
</div> -->