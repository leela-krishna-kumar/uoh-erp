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
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="form-label">{{ __('field_room') }} {{ __('field_no') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>

                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_room') }} {{ __('field_no') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="floor" class="form-label">{{ __('field_floor') }}</label>
                            <input type="text" class="form-control" name="floor" id="floor" value="{{ $row->floor }}">

                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_floor') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="capacity" class="form-label">{{ __('field_capacity') }}</label>
                            <input type="text" class="form-control autonumber" name="capacity" id="capacity" value="{{ $row->capacity }}" data-v-max="999999999" data-v-min="0">

                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_capacity') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type" class="form-label">{{ __('field_type') }}</label>
                            <!-- <input type="text" class="form-control" name="type" id="type" value="{{ $row->type }}"> -->
                            <select class="form-control" name="type" id="type" required>
                                <option value="1" @if($row->type == 1) selected @endif>{{ __('Class Room') }}</option>
                                <option value="2" @if($row->type == 2 ) selected @endif>{{ __('Lab') }}</option>
                            </select>
                            <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_type') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                          <div class="form-group">
                            <label for="light" class="form-label">{{ __('Lights') }}</label>
                            <input type="text" class="form-control autonumber" name="light" id="light" value="{{ $row->light }}" data-v-max="999999999" data-v-min="0">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Lights') }}
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="fan" class="form-label">{{ __('Fans') }}</label>
                            <input type="text" class="form-control autonumber" name="fan" id="fan" value="{{ $row->fan }}" data-v-max="999999999" data-v-min="0">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Fans') }}
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="bench" class="form-label">{{ __('Benches') }}</label>
                            <input type="text" class="form-control autonumber" name="bench" id="bench" value="{{ $row->bench }}"data-v-max="999999999" data-v-min="0">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Benches') }}
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="projecter" class="form-label">{{ __('Projecters') }}</label>
                            <input type="text" class="form-control autonumber" name="projecter" id="projecter" value="{{ $row->projecter }}" data-v-max="999999999" data-v-min="0">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Projecters') }}
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="size" class="form-label">{{ __('Room Size') }}</label>
                            <input type="text" class="form-control" name="size" id="size" value="{{ $row->size }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Room Size') }}
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="smart_room" class="form-label">{{ __('Smart Classroom ') }}</label>
                            <select class="form-control" name="smart_room" id="smart_room" required>
                                <option value="1" @if($row->smart_room == 1 ) selected @endif>{{ __('Yes') }}</option>
                                <option value="2" @if($row->smart_room == 2 ) selected @endif>{{ __('No') }}</option>
                            </select>
                            
                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Smart Classroom ') }}
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">{{ __('select_status') }}</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" @if( $row->status == 1 ) selected @endif>{{ __('status_active') }}</option>
                            <option value="0" @if( $row->status == 0 ) selected @endif>{{ __('status_inactive') }}</option>
                        </select>
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