

<div class="form-group">
    <label for="route-{{ $row->id }}">{{ __('field_route') }} <span>*</span></label>
    <select class="form-control" name="route" id="route-{{ $row->id }}" required>
        <option value="">{{ __('select') }}</option>
        @foreach( $transportRoutes as $transportRoute )
        <option value="{{ $transportRoute->id }}" @if(old('route') == $transportRoute->id) selected @endif>{{ $transportRoute->title }}</option>
        @endforeach
    </select>

    <div class="invalid-feedback">
      {{ __('required_field') }} {{ __('field_route') }}
    </div>
</div>

<div class="form-group">
    <label for="vehicle-{{ $row->id }}">{{ __('field_vehicle') }} <span>*</span></label>
    <select class="form-control" name="vehicle" id="vehicle-{{ $row->id }}" required>
        <option value="">{{ __('select') }}</option>
        @isset($vehicles)
        @foreach( $vehicles as $vehicle )
          <option value="{{ $vehicle->id }}" @if(old('vehicle') == $vehicle->id) selected @endif>{{ $vehicle->number }}</option>
        @endforeach
        @endisset
    </select>

    <div class="invalid-feedback">
      {{ __('required_field') }} {{ __('field_vehicle') }}
    </div>
</div>

<div class="form-group">
    <label for="halts-{{ $row->id }}">{{ __('field_halt') }} <span>*</span></label>
    <select class="form-control" name="halts" id="halts-{{ $row->id }}" required>
        <option value="">{{ __('select') }}</option>
        @isset($haltss)
        @foreach( $haltss as $halts )
          <option value="{{ $halts->id }}" @if(old('halts') == $halts->id) selected @endif>{{ $halts->number }}</option>
        @endforeach
        @endisset
    </select>

    <div class="invalid-feedback">
      {{ __('required_field') }} {{ __('field_halt') }}
    </div>
</div>

<div class="form-group">
    <label for="fee_category_id-{{ $row->id }}">{{ __('Fee Category') }} <span>*</span></label>
    <select class="form-control" name="fee_category_id" id="fee_category_id-{{ $row->id }}" required>
        <option value="">{{ __('select') }}</option>
        @isset($feeCategories)
        @foreach( $feeCategories as $feeCategory )
          <option value="{{ $feeCategory->id }}" @if(old('fee_category_id') == $feeCategory->id) selected @endif>{{ $feeCategory->title }}</option>
        @endforeach
        @endisset
    </select>

    <div class="invalid-feedback">
      {{ __('required_field') }} {{ __('Fee Category') }}
    </div>
</div>


<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>

<script type="text/javascript">
"use strict";
$("#route-{{ $row->id }}").on('change',function(e){
    e.preventDefault();
    var vehicle=$("#vehicle-{{ $row->id }}");
    var halts=$("#halts-{{ $row->id }}");
    var fee_category_id=$("#fee_category_id-{{ $row->id }}");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{ route('filter-vehicle') }}",
      data:{
        _token:$('input[name=_token]').val(),
        route:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', vehicle).remove();
          $('#vehicle-{{ $row->id }}').append('<option value="">{{ __("select") }}</option>');
          $.each(response.vehicles, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.number
            }).appendTo('#vehicle-{{ $row->id }}');
          });

          //append halt value
          $('option', halts).remove();
          $('#halts-{{ $row->id }}').append('<option value="">{{ __("select") }}</option>');
          $.each(response.halts, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('#halts-{{ $row->id }}');
          });

          //show selected fee_category_id on the bases of route
          var feeIdToSelect = response.fee_id;
          $('#fee_category_id-{{ $row->id }} option').removeAttr('selected');
          $('#fee_category_id-{{ $row->id }} option[value="' + feeIdToSelect + '"]').attr('selected', 'selected');
        }

    });
  });
</script>
