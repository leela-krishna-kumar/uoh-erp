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
                        <label for="name" class="form-label">{{ __('field_name') }} <span>*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $row->name }}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_name') }}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="type" class="form-label">{{ __('field_type') }} <span>*</span> </label>
                        <select class="form-control submissionType" name="type" id="type" required >
                            <option value="">{{ __('select') }}</option>
                            @foreach (App\Models\ApprovalSubmissionCategory::TYPES as $key => $type)
                            <option value="{{$key}}" @if($row->type = $key) selected @endif>{{$type['label']}}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_type') }}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">{{ __('field_description') }} <span>*</span><span class="available-variables ml-1"></span></label>
                        <textarea class="form-control" rows="8"name="description" id="description"required>{{ $row->description }}</textarea>

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