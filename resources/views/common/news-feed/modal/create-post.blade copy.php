<div id="addPost" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Add Post</h2>
        </div>
        <form class="needs-validation" action="{{ route($route.'.store-post') }}" method="post" enctype="multipart/form-data">
            <div class="uk-modal-body">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="content">{{ __('Content') }}</label>
                        <input type="text" class="form-control" name="content" id="content" value="{{ old('content') }}" required>
                    </div>


                    <div class="form-group col-md-12 mt-2">
                        <label for="media_type" class="form-label">Type <span>*</span></label>
                        <select class="form-control check-type" name="media_type" id="media_type" required>
                            <option value="">{{ __('Select') }}</option>
                            @foreach($mediaTypes as $key => $type)
                            <option value="{{$key}}" @if($key == 0) selected @endif>{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12 mt-2">
                        <div class="media-input">
                            <label for="media">{{ __('Media') }} <span>*</span></label>
                            <input type="file" class="form-control" name="media" id="media" value="{{ old('media') }}">
                        </div>
                        <div class="link-input d-none">
                            <label for="media">{{ __('Link') }} <span>*</span></label>
                            <input type="text" class="form-control" name="media" id="media" value="{{ old('media') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Post') }}</button>
            </div>
        </form>
    </div>
</div>