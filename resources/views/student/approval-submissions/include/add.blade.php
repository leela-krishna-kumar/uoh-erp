<div id="addSubmission" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Add Submission</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <fieldset class="row">
                  <div class=" form-group col-md-12">
                    <div class="form-group ">
                        <label for="link" >{{__(' Document Link')}}<span>*</span> </label>
                        <input required="" class="form-control" name="link" type="text" id="link" value="">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="student">{{ __('Approval Teacher') }} <span>*</span></label>
                    <select class="form-control select2" name="approver_id" id="student" required>
                        <option readonly value="">{{ __('select') }}</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" >{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @endforeach
                    </select>   
                  </div>
                  <div class="form-group col-md-12">
                    <label for="category_id">{{ __('Category') }} <span cl>*</span></label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach($approvalSubmissionCategory as $key => $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback">
                    {{ __('required_field') }} {{ __('Category') }}
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="note">{{ __('Note') }} <span>*</span></label>
                    <textarea type="text" class="form-control" name="note" rows="6"id="note" value=""required></textarea>
                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('note') }}
                    </div>
                </div>
             
                </fieldset>
            </div>
            <div class="uk-modal-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Submit') }}</button>
            </div>
        </form>
    </div>
</div>