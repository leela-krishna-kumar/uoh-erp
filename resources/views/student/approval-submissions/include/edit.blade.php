<div id="editSubmission-{{$row->id}}" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Edit Submission</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <fieldset class="row">
                  <div class=" form-group col-md-12">
                    <div class="form-group ">
                        <label for="link" >{{__(' Document Link')}}<span class="text-danger">*</span> </label>
                        <input required="" class="form-control" name="link" type="text" id="link" value="{{$row->link}}">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="student">{{ __('Approval Teacher') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="approver_id" id="student" required>
                        <option readonly value="">{{ __('select') }}</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" @if($teacher->id == $row->approver_id) selected @endif>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @endforeach
                    </select>   
                  </div>
                  <div class="form-group col-md-12">
                    <label for="category_id">{{ __('Category') }} <span>*</span></label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach($approvalSubmissionCategory as $key => $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback">
                    {{ __('required_field') }} {{ __('Category') }}
                    </div>
                  <div class="form-group col-md-12">
                    <label for="note">{{ __('Note') }}</label>
                    <textarea type="text" class="form-control" name="note" id="note" value="">{{$row->note}}</textarea>
                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('note') }}
                    </div>
                  </div>
                  
                </div>
                </fieldset>
            </div>
            <div class="uk-modal-footer text-right">
                <button type="submit" class="btn btn-success"> {{ __('Update') }}</button>
            </div>
        </form>
    </div>
</div>