    <!-- create modal content -->
    <div id="editExperienceModal-{{ $experience->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.experience.update',$experience->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$row->full_name}} {{ __('field_experience') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                     <fieldset class="row">
                        <div class="form-group col-md-6">
                           <label for="type">{{ __('Type') }}<span>*</span></label>
                           <select required class="form-control" name="type" id="type">
                               <option value="">{{ __('select') }}</option>
                               <option value="0" {{ $experience->type == 0 ? 'selected' : '' }}>Teaching</option>
                               <option value="1" {{ $experience->type == 1 ? 'selected' : '' }}>Working</option>
                               <option value="2" {{ $experience->type == 2 ? 'selected' : '' }}>Research</option>
                               <option value="3" {{ $experience->type == 3 ? 'selected' : '' }}>Industry</option>
                              </select>
                           <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('Type') }}
                           </div>
                       </div>
                        <div class="form-group col-md-6">
                           <label for="subject">{{ __('field_destination') }} <span>*</span></label>
                           <input type="text" class="form-control " name="subject" id="subject" value="{{ @$experience->subject }}" required>
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_destination') }}
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <label for="organization">{{ __('field_organization') }} <span>*</span></label>
                           <input type="text" class="form-control " name="organization" id="organization" value="{{ @$experience->organization }}" required>
                           <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_organization') }}
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
                        </div> --}}

                        <div class="form-group col-md-12">
                           <div class="form-check">
                               <input class="form-check-input" type="checkbox" id="presentCheckbox" value="" checked>
                               <label class="form-check-label" for="presentCheckbox">Present</label>
                           </div>
                       </div>
                       
                       <div class="form-group col-md-6">
                           <label for="from_date">{{ __('field_from_date') }}<span>*</span></label>
                           <input required type="date" class="form-control" name="from_date" id="from_date" value="{{ @$experience->from_date }}">
                           <div class="invalid-feedback">
                               {{ __('required_field') }} {{ __('field_from_date') }}
                           </div>
                       </div>
                       
                       <div class="form-group col-md-6">
                           <label for="to_date">{{ __('field_to_date') }}<span>*</span></label>
                           <input type="date" class="form-control" name="to_date" id="to_date" value="{{ @$experience->to_date }}">
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
                        </div>
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

