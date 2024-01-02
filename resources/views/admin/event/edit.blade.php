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
                        <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_title') }}
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="role_id" class="form-label">{{ __('field_role') }} <span>*</span></label>
                      <select class="form-control" name="role_id" id="role_id" required>
                          <option value="">{{ __('select') }}</option>
                          @foreach($roles as $key => $role)
                            @if($key === $roles->keys()->last())
                                <option value="0" @if($row->role_id == 0) selected @endif>{{ __('field_student') }}</option>
                            @endif
                            <option value="{{ $role->id }}" @if($row->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                          @endforeach
                      </select>

                      <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_role') }}
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="category_id">{{ __('field_category') }} <span>*</span></label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach( $event_categories as $category )
                        <option value="{{ $category->id }}" @if($category->id == $row->category_id) selected @endif>{{ $category->name}}</option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('field_category') }}
                    </div>
                </div>

                    <div class="form-group">
                        <label for="start_date" class="form-label">{{ __('field_start_date') }} <span>*</span></label>
                        <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ $row->start_date }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_start_date') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end_date" class="form-label">{{ __('field_end_date') }} <span>*</span></label>
                        <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $row->end_date }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_end_date') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="color" class="form-label">{{ __('field_color') }} <span>*</span></label>
                        <input type="text" class="form-control color_picker" name="color" id="color" value="{{ $row->color }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_color') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">{{ __('select_status') }}</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" @if( $row->status == 1 ) selected @endif>{{ __('status_active') }}</option>
                            <option value="0" @if( $row->status == 0 ) selected @endif>{{ __('status_inactive') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="color" class="form-label">{{ __('field_description') }} <span>*</span></label>
                      <textarea type="text" class="form-control" name="description" id="description" value="#70c24a" required>{{$row->description}}</textarea>

                      <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_description') }}
                      </div>
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