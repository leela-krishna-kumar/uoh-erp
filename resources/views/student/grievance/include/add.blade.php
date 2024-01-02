<div id="addGrievance" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Add Grievance</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <div class="row">
                <!-- Form Start -->
                <div class="form-group col-md-12">
                    <label for="student">{{ __('Category') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="category_id" required>
                        <option readonly value="">{{ __('Select') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endforeach
                    </select>   
                </div>
                <div class="form-group col-md-12">
                    <label for="department">{{ __('Department') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="department_id" required>
                        <option readonly value="">{{ __('Select') }}</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" >{{ $department->title }}</option>
                        @endforeach
                    </select>   
                </div>
                <div class="form-group col-md-12">
                    <label for="link">{{ __('Document Link') }}<span class="text-danger">*</span></label>
                    <textarea type="url" class="form-control" name="link" id="link" value="" required></textarea>
                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('link') }}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea type="text" class="form-control" name="description" id="description" value="" required></textarea>
                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('description') }}
                    </div>
                </div>

                <!-- Form End -->
                </div>
            </div>
            <div class="uk-modal-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>