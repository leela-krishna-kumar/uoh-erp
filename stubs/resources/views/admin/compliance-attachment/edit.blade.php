    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden"name="compliance_id"value="{{$row->compliance_id}}">
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
                        <label for="name" class="form-label">{{ __('field_upload') }} <span>*</span></label>
                        <input type="file" class="form-control" name="file" id="file" value="{{ old('file') }}" required>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_upload') }}
                        </div>
                    </div>

                    @if(is_file('uploads/'.$path.'/'.$row->file))
                        <div class="mt02">
                            <img src="{{ asset('uploads/'.$path.'/'.$row->file) }}" class="img-fluid" style="max-width: 80px; max-height: 80px;" onerror="this.src='{{ asset('dashboard/images/user/avatar-1.jpg') }}';">
                        </div>
                    @endif
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