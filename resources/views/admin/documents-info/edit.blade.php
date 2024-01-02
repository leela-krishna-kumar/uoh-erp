    <!-- create modal content -->
    <div id="editDocumentModal-{{ @$document->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- <form class="needs-validation" novalidate action="@isset($document) {{ route('admin.document.update',$document->id) }} @endisset" method="post">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    @method('PUT') -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$student->full_name}} {{ __('Documents') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                     <div class="modal-body">
                        <fieldset class="row">
                           <div class="form-group col-md-12">
                              <label for="title" class="form-label">{{ __('field_title') }} <span>*</span>
                              </label>
                              <input type="text" class="form-control" name="title" id="title" value="{{ @$document->title }}" required>
                              <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="title" class="form-label">{{ __('field_type') }} <span>*</span>
                              </label>
                              <select name="type_id" class="form-control select2" id="">
                                 <option value="" readonly>Select Document Type</option>
                                 @foreach ($documentTypes as $documentType)
                                     <option value="{{$documentType->id}}" @if ($documentType->id == $document->type_id) selected @endif>{{$documentType->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </fieldset>
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>