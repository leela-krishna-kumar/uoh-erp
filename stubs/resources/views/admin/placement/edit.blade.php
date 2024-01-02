    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                       <!-- Form Start -->
                       <div class="form-group">
                        <label for="status">{{ __('field_company') }}</label>
                        <select class="form-control" name="company_id" id="company_id" required>
                            <option value="">{{ __('select') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" @if($row->company_id == $company->id) selected @endif>{{ $company->name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_company') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="form-label">{{ __('field_date') }} <span>*</span></label>
                        <input type="date" class="form-control" name="date" id="date" value="{{$row->date}}" required>

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_date') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('field_description') }}</label>
                        <textarea type="text" class="form-control" name="description" id="description"rows="8" value="{{ old('description') }}">{{$row->description}}</textarea>

                        <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_description') }}
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