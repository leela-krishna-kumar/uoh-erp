@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <div class="form-group">
                                <label for="type" class="form-label">{{ __('vehicle_id') }} <span>*</span> </label>
                                <select class="form-control" name="vehicle_id"  id="vehicle" required >
                                    <option value="">{{ __('select') }}</option>
                                    @foreach ($vehicles as $key =>$vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->number . ' - ' . $vehicle->type }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="type" class="form-label">{{ __('driver_id') }} <span>*</span> </label>
                                <select class="form-control" name="driver_id"  id="driver" required >
                                    <option value="">{{ __('select') }}</option>
                                    @foreach($drivers as $key => $driver)
                                   <option value="{{ $driver->id }}">{{ $driver->first_name ?: '--' }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="date" class="form-label">{{ __('date') }}<span>*</span></label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required>
                            </div>

                    
                              <div class="row">
                                   <div class="form-group col-6">
                                        <label for="StartTime" class="form-label">{{ __('start_time') }}<span>*</span></label>
                                        <input type="time" class="form-control" name="start_time" id="start_time" value="{{ old('start_time') }}" required>

                                    </div>
                                    <div class="form-group col-6">
                                        <label for="capacity" class="form-label">{{ __('end_time') }}<span>*</span></label>
                                        <input type="time" class="form-control" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="capacity" class="form-label">{{ __('checkin_odometter') }}<span>*</span></label>
                                        <input type="datetime-local" class="form-control" name="checkin_odometer" id="checkin_odometer" value="{{ old('checkin_odometer') }}" required>

                                    </div>
                                    <div class="form-group col-6">
                                        <label for="capacity" class="form-label">{{ __('checkout_odometer') }}<span>*</span></label>
                                        <input type="datetime-local" class="form-control" name="checkout_odometer" id="checkout_odometer" value="{{ old('checkout_odometer') }}" required>
                                    </div>  
                               </div>
                          
                                    <div class="form-group">
                                        <label for="capacity" class="form-label">{{ __('note') }}</label>
                                        <input type="text" class="form-control" name="note" id="note" value="{{ old('note') }}">
                                    </div>

                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
             <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('vehicle_id') }}
                                         <div class="hr-1"></div>
                                         {{ __('driver_id') }}
                                        </th>
                                        <th>{{ __('date') }}</th>
                                        <th>{{ __('start_time') }}
                                           <div class="hr-1"></div>
                                            {{ __('end_time') }}
                                        </th>
                                         <th>{{ __(' Odometter Difference') }}</th>
                                        {{-- <th>{{ __('checkin_odometter') }}</th>
                                        <th>{{ __('checkout_odometter') }}</th> --}}
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{@$row->vehicleLog->type}}
                                            <div class="hr-1"></div>
                                            {{@$row->driver->first_name}}
                                        </td>
                                        <td>{{@$row->date}}</td>
                                        <td>{{@$row->start_time }}
                                          <div class="hr-1"></div>
                                         
                                            {{@$row->end_time }}
                                        </td>
                                        {{-- <td>{{@$row->checkin_odometer }}</td>
                                        <td>{{@$row->checkin_odometer }}</td>
                                        --}}
                                       <td>
                                            @php
                                                $checkinTime = \Carbon\Carbon::parse($row->checkin_odometer);
                                                $checkoutTime = \Carbon\Carbon::parse($row->checkout_odometer);

                                                $timeDifference = $checkoutTime->diff($checkinTime);

                                                // Format the time difference as a string
                                                $formattedDifference = $timeDifference->format('%y/%m/%d %H:%I:%S');
                                            @endphp

                                            {{ $formattedDifference }}
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                              @include($view.'.model')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection