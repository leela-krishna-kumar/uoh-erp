
<div class="form-group col-md-4">
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
<div class="form-group col-md-4">
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
<div class="form-group col-md-4">
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

