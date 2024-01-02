<form class="needs-validation mt-3" novalidate action="{{ route('admin.update-payroll',$row->id) }}" method="post">
    @csrf
   <input type="hidden" name="user_id" value="{{ $row->id }}">
  <fieldset class="row scheduler-border">
    <legend>{{ __('tab_payroll_details') }}</legend>
    <div class="form-group col-md-4">
       <label for="contract_type">{{ __('field_contract_type') }} <span>*</span></label>
       <select class="form-control" name="contract_type" id="contract_type" required>
          <option value="">{{ __('select') }}</option>
          <option value="1" @if(isset($row) && $row->contract_type == 1 ) selected @endif>{{ __('contract_type_full_time') }}</option>
          <option value="2" @if(isset($row) && $row->contract_type == 2 ) selected @endif>{{ __('contract_type_part_time') }}</option>
       </select>
       <div class="invalid-feedback">
          {{ __('required_field') }} {{ __('field_contract_type') }}
       </div>
    </div>
    <div class="form-group col-md-4">
       <label for="work_shift">{{ __('field_work_shift') }} <span>*</span></label>
       <select class="form-control" name="work_shift" id="work_shift" required>
          <option value="">{{ __('select') }}</option>
          @foreach($work_shifts as $shift )
          <option value="{{ $shift->id }}" @if($row->work_shift == $shift->id ) selected @endif>{{ $shift->title }}</option>
          @endforeach
       </select>
       <div class="invalid-feedback">
          {{ __('required_field') }} {{ __('field_work_shift') }}
       </div>
    </div>
    <div class="form-group col-md-4">
       <label for="salary_type">{{ __('field_salary_type') }} <span>*</span></label>
       <select class="form-control" name="salary_type" id="salary_type" required>
          <option value="">{{ __('select') }}</option>
          <option value="1" @if(isset($row) && $row->salary_type == 1 ) selected @endif>{{ __('salary_type_fixed') }}</option>
          <option value="2" @if(isset($row) && $row->salary_type == 2 ) selected @endif>{{ __('salary_type_hourly') }}</option>
       </select>
       <div class="invalid-feedback">
          {{ __('required_field') }} {{ __('field_salary_type') }}
       </div>
    </div>
    <div class="form-group col-md-4">
       <label for="basic_salary">{{ __('salary_type_hourly') }} / {{ __('salary_type_fixed') }} {{ __('field_salary') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
       <input type="text" class="form-control autonumber" name="basic_salary" id="basic_salary" value="{{ @$row->basic_salary }}" required>
       <div class="invalid-feedback">
          {{ __('required_field') }} {{ __('salary_type_hourly') }} / {{ __('salary_type_fixed') }} {{ __('field_salary') }}
       </div>
    </div>
    <div class="form-group col-md-4">
       <label for="epf_no">{{ __('field_epf_no') }}</label>
       <input type="text" class="form-control" name="epf_no" id="epf_no" value="{{ $row->epf_no }}">
       <div class="invalid-feedback">
          {{ __('required_field') }} {{ __('field_epf_no') }}
       </div>
    </div>
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
  </fieldset>
</form>