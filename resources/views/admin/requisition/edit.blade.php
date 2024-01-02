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
                      
                        <div class="form-group col-md-6">
                                <label for="note">{{trans_choice('module_requisition_book_name',1) }}<span>*</span></label>
                                <input required type="text" class="form-control" name="book_name" id="book_name" value="{{$row->book_name}}">
                               
                                <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('module_requisition_book_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="note">{{trans_choice('module_requisition_author_name',1) }}<span>*</span></label>
                                <input required type="text" class="form-control" name="author_name" id="author_name" value="{{$row->author_name}}">                       
                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('module_requisition_author_name') }}
                                </div>
                            </div>
                      <div class="form-group col-md-12">
                            <label for="member">{{trans_choice('module_accordion_status',1) }}<span>*</span></label>
                            <select class="form-control select2" name="status" id="status" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach($statuses as $key => $status )
                                 <option value="{{ $key }}" @if($key == $row->status) selected @endif> {{ $status['label'] }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Status') }}
                            </div>
                        </div>

                            <div class="form-group col-md-12">
                                <label for="note">{{trans_choice('module_requisition_remark',1) }}</label>
                                <textarea type="text" class="form-control" name="remark" id="remark" cols="20" rows="5">{{$row->remark}}</textarea>
                                
                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('module_requisition_remark') }}
                                </div>
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