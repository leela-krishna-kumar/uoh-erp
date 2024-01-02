    <!-- create modal content -->
    <div id="editCollegeModal-{{ @$college_education->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="@isset($college_education) {{ route('admin.education.update',$college_education->id) }} @endisset" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$student->full_name}} {{ __('field_college_information') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                     <div class="modal-body">
                        <fieldset class="row">
                           <div class="form-group col-md-12">
                              <label for="collage_name">{{ __('field_collage_name') }}<span>*</span></label>
                              <input type="text" class="form-control" name="payload[collage_name]" id="collage_name" value="{{ @$college_education->payload['collage_name'] }}" required>
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_collage_name') }}
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="institution">{{ __('field_institution') }}<span>*</span></label>
                              <input type="text" class="form-control" name="payload[institution]" id="institution" value="{{ @$college_education->payload['institution'] }}" required>
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_institution') }}
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="collage_exam_id">{{ __('field_exam_id') }}<span>*</span></label>
                              <input type="text" class="form-control" name="payload[collage_exam_id]" id="collage_exam_id" value="{{ @$college_education->payload['collage_exam_id'] }}" required>
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_exam_id') }}
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="hall_ticket_no">{{ __('field_hall_ticket_no') }}<span>*</span></label>
                              <input type="text" class="form-control" name="payload[hall_ticket_no]" required id="hall_ticket_no" value="{{ @$college_education->payload['hall_ticket_no'] }}">
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_hall_ticket_no') }}
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                             <label for="collage_graduation_year">{{ __('field_graduation_year') }}<span>*</span></label>
                             <input type="month" class="form-control" name="payload[collage_graduation_year]" id="collage_graduation_year" value="{{ @$college_education->payload['collage_graduation_year'] }}" required>
                             <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_graduation_year') }}
                             </div>
                          </div>
                           <div class="form-group col-md-6">
                              <label for="collage_graduation_point">{{ __('field_graduation_point') }}(CGPA)<span>*</span></label>
                              <input type="number" step="any" max="10" class="form-control" name="payload[collage_graduation_point]" id="collage_graduation_point" value="{{ @$college_education->payload['collage_graduation_point'] }}" required>
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_graduation_point') }}
                              </div>
                           </div>
                       </fieldset>
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>