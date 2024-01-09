@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <!-- <div class="form-group col-md-3">
                                    <label for="year">{{ __('field_year') }} <span>*</span></label>
                                        <select id="year" class="form-control" name="year"></select>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_year') }}
                                        </div>
                                </div> -->
                                @include('common.inc.fees-type-master.search-filter')

                                <div class="form-group col-md-3">
                                    <label for="seat_type_id">{{ __('field_seat_type') }} <span>*</span></label>
                                    <select class="form-control" name="seat_type_id" id="seat_type_id" required>
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach($seat_types as $seat_type )
                                        <option value="{{ $seat_type->id }}"@if( $selected_seat_type == $seat_type->id) selected @endif >{{ $seat_type->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_seat_type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    @if(isset($rows))
                    <div class="card-block">
                        <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="faculty" value="{{ $selected_faculty }}" hidden>
                            <input type="text" name="program" value="{{ $selected_program }}" hidden>
                            <input type="text" name="session" value="{{ $selected_session }}" hidden>
                            <input type="text" name="year" value="{{ $selected_year }}" hidden>
                            <input type="text" name="seat_type_id" value="{{ $selected_seat_type }}" hidden>
                            {{-- <input type="text" name="section" value="{{ $selected_section }}" hidden> --}}
                            <div class="row">
                                @foreach($rows as $key => $row)

                                @if ($row->department_id != 24 && $row->department_id != 39)                                    
                                
                                    @php
                                        $feesTypeMaster =  App\Models\FeesTypeMaster::where('faculty_id',request()->get('faculty'))->where('program_id',request()->get('program'))->where('seat_type_id',request()->get('seat_type_id'))->where('fees_type_id',$row->id)->latest()->first();
                                        if($feesTypeMaster){
                                            $value = $feesTypeMaster->amount;
                                        }else{
                                            $value = $row->amount;
                                        }
                                    @endphp
                                    <input type="hidden" name="fees_types[{{ $row->id }}][fees_type_id]" value="{{ $row->id }}">
                                    <div class="col-md-3 form-group">
                                        <div>
                                            <label for="fees_type_id">{{ $row->title}}</label>
                                            <input type="number" name="fees_types[{{ $row->id }}][amount]" value="{{ $value }}"class="form-control">
                                        </div>
                                    </div>

                                @endif
                                @endforeach
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_save') }}</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script>
    // Get the select element
    const yearSelect = document.getElementById("year");
  
    // Define the range of years you want to display
    const startYear = 2000;
    const endYear = new Date().getFullYear(); // Gets the current year
  
    // Generate the list of years and add them to the select element
    for (let year = endYear; year >= startYear; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.text = year;
        yearSelect.appendChild(option);
    }
  </script>
@endsection