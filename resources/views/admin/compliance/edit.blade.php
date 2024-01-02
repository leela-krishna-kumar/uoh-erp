    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-block">
                        <div class="row">
                            <!-- Form Start -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{$row->title}}" required>

                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_title') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="category_id">{{ __('field_category') }} <span>*</span></label>
                                        <select class="form-control" name="category_id" id="category_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($row->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_category') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="note">{{ __('field_note') }} <span>*</span></label>
                                            <textarea type="text" class="form-control" name="note" id="note"rows="8" required>{{$row->note}}</textarea>

                                            <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_note') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4"></div>
                        <!-- Form End -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

