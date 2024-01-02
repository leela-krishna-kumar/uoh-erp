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
                    <input type="hidden" name="post_id" value="{{$row->post_id}}">
                <div class="modal-body">
                       <!-- Form Start -->
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
                        <label for="comment">{{ __('Comment') }}</label>
                        <textarea type="text" class="form-control" name="comment" id="comment" >{{$row->comment}}</textarea>
      
                        <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('Comment') }}
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