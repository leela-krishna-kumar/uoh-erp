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
                            <label for="book">{{trans_choice('module_accordion_book',1) }} <span>*</span></label>
                            <select class="form-control select2" name="book_id" id="book_id" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $books as $book )
                                <option value="{{ $book->id }}" @if($row->book_id == $book->id) selected @endif> {{ $book->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_book') }}
                            </div>
                      </div>
                      <div class="form-group col-md-6">
                            <label for="member">{{trans_choice('module_accordion_department',1) }}<span>*</span></label>
                            <select class="form-control select2" name="department_id" id="department_id" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $depatments as $depatment )
                                 <option value="{{ $depatment->id }}" @if($row->department_id == $depatment->id) selected @endif> {{ $depatment->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('module_accordion_department') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="member">{{trans_choice('module_accordion_status',1) }}<span>*</span></label>
                            <select class="form-control select2" name="status" id="status" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach( $statuses as $key => $status )
                                 <option value="{{ $key }}" @if($key == $row->status) selected @endif> {{ $status['label'] }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('module_accordion_status') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_date">{{trans_choice('module_accession_no',1) }} <span>*</span></label>
                            <input type="number" class="form-control" name="accordion_no" id="accordion_no" value="{{ $row->accordion_no}}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('module_accession_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="note">{{trans_choice('module_accordion_note',1) }}</label>
                             <textarea type="text" class="form-control" name="note" id="note" cols="20" rows="5" value="">{{ $row->note}}</textarea>
                           
                             <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('module_accordion_note') }}
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