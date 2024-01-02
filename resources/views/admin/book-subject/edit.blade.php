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
                                 <div class="col-12"> 
                                      <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                          <label for="book_id" class="control-label">{{ __('field_book_id') }}<span class="text-danger">*</span> </label>
                                         <select name="book_id" class="form-control select2" id="book_id">
                                            <option value="" readonly>Select Book</option>
                                            @foreach ($books as $book)
                                              <option value="{{ $book->id }}"@if($book->id==$row->book_id) selected @endif>{{ $book->title }}</option>
                                            @endforeach
                                         </select>
                                           <div class="invalid-feedback">
                                               {{ __('required_field') }} {{ __('field_book_id') }}
                                           </div>
                                     </div>
                                </div>
                            <div class="form-group">
                                <label for="subject" class="form-label">{{ __('field_book_subject') }} <span>*</span></label>
                                <input type="text" class="form-control" name="subject" id="subject" value="{{$row->subject }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_book_subject') }}
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