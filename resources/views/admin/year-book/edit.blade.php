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
                                <label for="title" class="form-label">{{ __('Title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ $row->title  }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('title') }}
                                </div>
                            </div>                      
                            <div class="form-group">
                                <label for="year" class="form-label">{{ __('Year') }} <span>*</span></label>
                                <input type="number" class="form-control" name="year" id="year" value="{{$row->year }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('year') }}
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea type="text" class="form-control" name="description" id="description" value="">{{$row->description }}</textarea>                             
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