<form class="needs-validation mt-3" novalidate action="{{ route('admin.document.store') }}" method="post">
    @csrf
    @method('PUT')
   <input type="hidden" name="type" value="user">
   <input type="hidden" name="user_id" value="{{ $row->id }}">
        <fieldset class="row scheduler-border">
            <div class="form-group col-md-6">
            <label for="photo">{{ __('field_photo') }}: <span>{{ __('image_size', ['height' => 300, 'width' => 300]) }}</span></label>
            <input type="file" class="form-control" name="photo" id="photo" value="{{ old('photo') }}">
            <div class="invalid-feedback">
                {{ __('required_field') }} {{ __('field_photo') }}
            </div>
            </div>
            <div class="form-group col-md-6">
            <label for="signature">{{ __('field_signature') }}: <span>{{ __('image_size', ['height' => 100, 'width' => 300]) }}</span></label>
            <input type="file" class="form-control" name="signature" id="signature" value="{{ old('signature') }}">
            <div class="invalid-feedback">
                {{ __('required_field') }} {{ __('field_signature') }}
            </div>
            </div>
            <div class="form-group col-md-6">
            <label for="resume">{{ __('field_resume') }}</label>
            <input type="file" class="form-control" name="resume" id="resume" value="{{ old('resume') }}">
            <div class="invalid-feedback">
                {{ __('required_field') }} {{ __('field_resume') }}
            </div>
            </div>
            <div class="form-group col-md-6">
            <label for="joining_letter">{{ __('field_joining_letter') }}</label>
            <input type="file" class="form-control" name="joining_letter" id="joining_letter" value="{{ old('joining_letter') }}">
            <div class="invalid-feedback">
                {{ __('required_field') }} {{ __('field_joining_letter') }}
            </div>
            </div>
        </fieldset>
        <fieldset class="row scheduler-border">
            <legend>{{ __('field_upload') }} {{ __('field_document') }}</legend>
            <div class="container-fluid">
            <div id="newDocument" class="clearfix"></div>
            <div class="form-group">
                <button id="addDocument" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
            </div>
            </div>
        </fieldset>
 <div class="row">
     <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
 </div>
</form>