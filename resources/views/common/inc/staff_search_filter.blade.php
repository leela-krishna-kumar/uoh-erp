<div class="form-group col-md-2">
  <label for="department">{{ __('field_department') }}</label>
  <select class="form-control" name="department" id="department" required>
      <option value="">{{ __('select') }}</option>
      @foreach( $departments as $department )
      <option value="{{ $department->id }}" @if( $selected_department == $department->id) selected @endif>{{ $department->title }}</option>
      @endforeach
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_department') }}
  </div>
</div>
<div class="form-group col-md-2">
  <label for="designation">{{ __('field_designation') }}</label>
  <select class="form-control" name="designation" id="designation">
      <option value="">{{ __('all') }}</option>
      @foreach( $designations as $designation )
      <option value="{{ $designation->id }}" @if( $selected_designation == $designation->id) selected @endif>{{ $designation->title }}</option>
      @endforeach
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_designation') }}
  </div>
</div>
<div class="form-group col-md-2">
  <label for="role">{{ __('field_role') }}</label>
  <select class="form-control" name="role" id="role">
      <option value="">{{ __('all') }}</option>
      @foreach($roles as $role )
      <option value="{{ $role->id }}" @if( $selected_role == $role->id) selected @endif>{{ $role->name }}</option>
      @endforeach
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_role') }}
  </div>
</div>
<div class="form-group col-md-2">
  <label for="contract_type">{{ __('field_contract_type') }} </label>
  <select class="form-control" name="contract_type" id="contract_type">
      <option value="">{{ __('all') }}</option>
      <option value="1" {{ $selected_contract == 1 ? 'selected' : '' }}>{{ __('contract_type_full_time') }}</option>
      <option value="2" {{ $selected_contract == 2 ? 'selected' : '' }}>{{ __('contract_type_part_time') }}</option>
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_contract_type') }}
  </div>
</div>
<div class="form-group col-md-2">
  <label for="shift">{{ __('field_work_shift') }}</label>
  <select class="form-control" name="shift" id="shift">
      <option value="">{{ __('all') }}</option>
      @foreach( $work_shifts as $shift )
      <option value="{{ $shift->id }}" @if( $selected_shift == $shift->id) selected @endif>{{ $shift->title }}</option>
      @endforeach
  </select>

  <div class="invalid-feedback">
    {{ __('required_field') }} {{ __('field_work_shift') }}
  </div>
</div>