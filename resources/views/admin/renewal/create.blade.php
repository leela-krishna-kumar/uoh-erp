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
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="post" action="{{ route($route.'.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name<span>*</span></label>
                                        <input required type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="renewal_category_id">Category<span>*</span></label>
                                        <select required class="form-control" name="renewal_category_id" id="renewal_category_id">
                                            <option value="">{{ __('select') }}</option>
                                            @foreach ($renewal_categories as $key => $renewal_category)
                                            <option value="{{$renewal_category->id}}">{{ $renewal_category->name }}</option>
                                            @endforeach
                                        </select>
                                    <div class="invalid-feedback"> {{ __('field_status') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="vehicle_id">Vehicle<span>*</span></label>
                                        <select required class="form-control" name="vehicle_id" id="vehicle_id">
                                            <option value="">{{ __('select') }}</option>
                                            @foreach ($vehicles as $key => $vehicle)
                                            <option value="{{$vehicle->id}}">{{ $vehicle->number }} | {{ $vehicle->type }}</option>
                                            @endforeach
                                        </select>
                                    <div class="invalid-feedback"> {{ __('vehicle_id') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="renewal_date">Renewal Date<span>*</span></label>
                                        <input required type="date" name="renewal_date" id="renewal_date" class="form-control" value="{{old('renewal_date')}}">
                                    <div class="invalid-feedback"> {{ __('renewal_date') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="expiry_date">Expiry Date<span>*</span></label>
                                        <input required type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{old('expiry_date')}}">
                                    <div class="invalid-feedback"> {{ __('expiry_date') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="note">Note</label>
                                        <textarea type="text" name="note" id="note" class="form-control" value="{{old('note')}}"></textarea>
                                    <div class="invalid-feedback"> {{ __('note') }}
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
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
@section('page_js')

@yield('sub-script')
<script>
    function onlyOne(checkbox) {
      var checkboxes = document.getElementsByName('student_id')
      checkboxes.forEach((item) => {
          if (item !== checkbox) item.checked = false
      })
}
  </script>

@endsection