    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{route('admin.test-paper-question.update',$row->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="testpaper_id" value="{{$testPaper->id}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group col-md-12">
                      <label for="semester">{{ __('Subjects') }}</label>
                        <select class="form-control" name="subject_id"id="subjectId">
                            <option value="">{{ __('Select Subject') }}</option>
                            @foreach($subjects as $key => $subject)
                                <option value="{{$subject->id}}" @if($key == 0) selected @endif>{{ $subject->title }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('Subjects') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="form-label">{{ __('Select Questions') }} <span>*</span></label>
                        <select class="form-control question" name="question_bank_id" id="question_bank_id" required>
                        </select>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('Questions') }}
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