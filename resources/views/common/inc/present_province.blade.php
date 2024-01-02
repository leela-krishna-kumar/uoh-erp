<div class="form-group col-md-4">
  <label for="present_country">{{ __('field_country') }}<span>*</span></label>
  <select class="form-control" name="present_country" id="present_country" required>
    <option value=""readonly>{{ __('select') }}</option>
      @isset($countries)
        @foreach( $countries as $country )
        <option value="{{ $country->id }}" @isset($present_address) {{ @$present_address->country_id == $country->id ? 'selected' : '' }} @endisset>{{ $country->title }}</option>
        @endforeach
      @endisset
  </select>
  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_country') }}
  </div>
</div>
<div class="form-group col-md-4">
  <label for="present_province">{{ __('field_province') }}<span>*</span></label>
  <select class="form-control" name="present_province" id="present_province" required>
    <option value="" readonly>{{ __('select') }}</option>
    {{-- @isset($provinces)
    @foreach( $provinces as $province )
      <option value="{{ $province->id }}" @isset($present_address) {{ @$present_address->state_id == $province->id ? 'selected' : '' }} @endisset>{{ $province->title }}</option>
    @endforeach
    @endisset --}}
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_province') }}
  </div>
</div>
<div class="form-group col-md-4">
  <label for="present_district">{{ __('field_district') }}<span>*</span></label>
  <select class="form-control" name="present_district" id="present_district" required>
    <option value="" readonly>{{ __('select') }}</option>
    @isset($present_districts)
    @foreach($present_districts as $district)
      <option value="{{ $district->id }}" >{{ $district->title }}</option>
    @endforeach
    @endisset
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_district') }}
  </div>
</div>
