<div class="form-group col-md-4">
  <label for="permanent_country">{{ __('field_country') }}<span>*</span></label>
  <select class="form-control" name="permanent_country" id="permanent_country" required>
    <option value="" readonly>{{ __('select') }}</option>
    @isset($countries)
    @foreach($countries as $country )
    <option value="{{ $country->id }}" @isset($permanent_address) {{ $permanent_address->country_id == $country->id ? 'selected' : '' }} @endisset>{{ $country->title }}</option>
    @endforeach
    @endisset
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_country') }}
  </div>
</div>
<div class="form-group col-md-4">
  <label for="permanent_province">{{ __('field_province') }}<span>*</span></label>
  <select class="form-control" name="permanent_province" id="permanent_province" required>
    <option value="" readonly>{{ __('select') }}</option>
    {{-- @isset($provinces)
    @foreach( $provinces as $province )
    <option value="{{ $province->id }}" @isset($permanent_address) {{ @$permanent_address->state_id == $province->id ? 'selected' : '' }} @endisset>{{ $province->title }}</option>
    @endforeach
    @endisset --}}
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_province') }}
  </div>
</div>

<div class="form-group col-md-4">
  <label for="permanent_district">{{ __('field_district') }}<span>*</span></label>
  <select class="form-control" name="permanent_district" id="permanent_district" required>
    <option value="" readonly>{{ __('select') }}</option>
    @isset($permanent_districts)
    @foreach($permanent_districts as $district)
    <option value="{{ $district->id }}">{{ $district->title }}</option>
    @endforeach
  @endisset
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_district') }}
  </div>
</div>
