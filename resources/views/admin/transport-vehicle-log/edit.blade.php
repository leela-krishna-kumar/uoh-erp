    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                   <div class="form-group">
                        <label for="type" class="form-label">{{ __('vehicle_id') }} <span>*</span> </label>
                            <select class="form-control" name="vehicle_id"  id="vehicle" required >
                                <option value="">{{ __('select') }}</option>
                                @foreach ($vehicles as $key =>$vehicle )
                                <option value="{{$vehicle->id}}"@if($row->vehicle_id == $vehicle->id ) selected @endif>{{$vehicle->type}}</option>
                                @endforeach
                            </select>
                    </div>

                      <div class="form-group">
                         <label for="type" class="form-label">{{ __('driver_id') }} <span>*</span> </label>
                            <select class="form-control" name="driver"  id="driver" required >
                                <option value="">{{ __('select') }}</option>
                                @foreach ($drivers as $key =>$driver)
                                <option value="{{ $driver->id }}"@if($row->driver_id == $driver->id) selected @endif>{{ $driver->first_name ?: '--' }}</option>
                                @endforeach
                            </select>
                        </div>
                  
                            <div class="form-group">
                                <label for="Date" class="form-label">{{ __('date') }}<span>*</span></label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ $row->date}}" required>
                            </div>               
                           <div class="row">
                                  <div class="form-group col-6">
                                        <label for="time" class="form-label">{{ __('start_time') }}<span>*</span></label>
                                        <input type="time" class="form-control" name="start_time" id="start_time" value="{{ $row->start_time}}" required>

                                    </div>
                                    <div class="form-group col-6">
                                        <label for="time" class="form-label">{{ __('end_time') }}<span>*</span></label>
                                        <input type="time" class="form-control" name="end_time" id="end_time" value="{{ $row->end_time}}" required>

                                    </div>
                                    <div class="form-group col-6">
                                        <label for="checkin_odometter" class="form-label">{{ __('checkin_odometter') }}<span>*</span></label>
                                        <input type="datetime-local" class="form-control" name="checkin_odometer" id="checkin_odometer" value="{{ $row->checkin_odometer}}" required>

                                    </div>
                                    <div class="form-group col-6">
                                        <label for="checkout_odometer" class="form-label">{{ __('checkout_odometer') }}<span>*</span></label>
                                        <input type="datetime-local" class="form-control" name="checkout_odometer" id="checkout_odometer" value="{{ $row->checkout_odometer}}" required>

                                    </div>
                           </div>

                           <div class="form-group">
                                <label for="Note" class="form-label">{{ __('note') }}</label>
                                <input type="text" class="form-control" name="note" id="note" value="{{ $row->note}}">
                            </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                </div>

              </form>
            </div>
        </div>
    </div>