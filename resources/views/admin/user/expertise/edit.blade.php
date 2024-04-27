    <!-- create modal content -->
    <div id="editExpertiseModal-{{ @$expertise->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.expertise.update',$expertise->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <div class="modal-header">
                     <h5 class="modal-title" id="myModalLabel">{{$row->full_name}} Expertise </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                     {{-- <fieldset class="row">
                        <div class="form-group col-md-6">
                           <label for="type">{{ __('Type') }} <span>*</span></label>
                           <select class="form-control" name="type" id="type">
                              <option value="">{{ __('select') }}</option>
                              @foreach ($types as $key => $types)
                                 <option value="{{$key}}" @if ($experience && $key == $experience->type) selected @endif>{{$types['label']}}</option>
                              @endforeach
                           </select>
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('Type') }}
                           </div>
                        </div> --}}
                        <div class="form-group col-md-6">
                            <label for="area_of_expertise">Area of Expertise<span>*</span></label>
                            <input type="text" class="form-control " name="area_of_expertise" id="area_of_expertise" value="{{ $expertise->area_of_expertise }}" required>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_area_of_expertise') }}
                            </div>
                         </div>
                         <div class="form-group col-md-12">
                            <label for="topics">{{ __('Topics') }} <span>*</span></label>
                            <input type="text" class="form-control" name="topics" id="topics" value="{{ $expertise->topics }}" required>
                            <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_topics') }}
                            </div>
                         </div>
                        {{-- <div class="form-group col-md-6">
                           <label for="from_date">{{ __('field_from_date') }} </label>
                           <input type="date" class="form-control " name="from_date" id="from_date" value="{{ @$experience->from_date }}" >
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_from_date') }}
                           </div>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="to_date">{{ __('field_to_date') }} </label>
                           <input type="date" class="form-control " name="to_date" id="to_date" value="{{ @$experience->to_date }}" >
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_to_date') }}
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <label for="remark">{{ __('field_remark') }} </label>
                           <textarea type="text" class="form-control " name="remark" id="remark">{{ @$experience->remark }}</textarea>
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_remark') }}
                           </div>
                        </div> --}}
                     </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
