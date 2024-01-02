<div id="editProject-{{$row->id}}" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Add Project</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.update',$row->id) }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <fieldset class="row">
                  <div class=" form-group col-md-12">
                    <div class="form-group ">
                        <label for="title" >{{__('Title')}}<span class="text-danger">*</span> </label>
                        <input required class="form-control" name="title" type="text" id="title" value="{{$row->title}}">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="student">{{ __('Category') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="project_category_id" required>
                        <option readonly value="">{{ __('Select') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $row->project_category_id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>   
                  </div>
                  <div class="form-group col-md-12">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea type="text" class="form-control" name="description" id="description" value="">{{$row->description}}</textarea>
                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('description') }}
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