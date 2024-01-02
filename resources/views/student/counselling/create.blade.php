<div id="addCounselling" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Add Counselling</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <fieldset class="row">
                  <div class=" form-group col-md-6">
                    <div class="form-group ">
                        <label for="date" >{{__('Date')}}<span class="text-danger">*</span> </label>
                        <input required class="form-control" name="date" type="date" id="date" value="">
                    </div>
                  </div>
                  <div class=" form-group col-md-6">
                    <div class="form-group ">
                        <label for="time" >{{__('Time')}}<span class="text-danger">*</span> </label>
                        <input required class="form-control" name="time" type="time" id="time" value="">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="student">{{ __('Category') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="counselling_category_id" required>
                        <option readonly value="">{{ __('Select') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endforeach
                    </select>   
                  </div>
                    <div class="form-group col-md-12">
                        <label for="note">{{ __('Note') }}</label>
                        <textarea type="text" class="form-control" name="note" id="note" value=""></textarea>
                        <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('note') }}
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="uk-modal-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Add') }}</button>
            </div>
        </form>
    </div>
</div>