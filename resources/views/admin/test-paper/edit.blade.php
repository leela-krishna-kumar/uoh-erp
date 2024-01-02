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
                        <label for="name" class="form-label">{{ __('field_title') }} <span>*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $row->title }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_title') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">{{ __('field_type') }} <span>*</span></label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="">{{ __('select') }}</option>
                            @foreach (App\Models\TestPaper::TYPES as $key => $class)
                            <option value="{{$key}}" @if( $row->type == $key) selected @endif>{{ $class['label'] }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_type') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="duration" class="form-label">{{ __('Duration') }} ({{ __('In min.') }}) <span>*</span></label>
                        <input type="number" class="form-control" name="duration" id="duration" value="{{ $row->duration }}" required  min="1">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('duration') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="started_from" class="form-label">{{ __('Start Date') }} <span>*</span></label>
                        <input type="date" class="form-control" name="started_from" id="started_from" value="{{ $row->started_from }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('Start Date') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="form-label">{{ __('field_end_date') }} <span>*</span></label>
                        <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $row->end_date }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_end_date') }}
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