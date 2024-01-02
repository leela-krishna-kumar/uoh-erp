    <!-- create modal content -->
    <div id="editEntranceModal-{{ @$entrance->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="@isset($entrance) {{ route('admin.entrance.update',$entrance->id) }} @endisset" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$student->full_name}} {{ __('field_entrance_information') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                     <div class="modal-body">
                        <fieldset class="row">
                           <div class="form-group col-md-12">
                              <label for="exam_name">{{ __('Exam Name') }}<span>*</span></label>
                              <input required type="text" class="form-control" name="payload[exam_name]" id="exam_name" value="{{ @$entrance->payload['exam_name'] }}">
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_exam_name') }}
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="hall_ticket_no">{{ __('Hall Ticket No') }}<span>*</span></label>
                              <input required type="text" class="form-control" name="payload[hall_ticket_number]" id="hall_ticket_no" value="{{ @$entrance->payload['hall_ticket_number'] }}">
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_hall_ticket_no') }}
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="rank">{{ __('Rank') }}<span>*</span></label>
                              <input required type="number" min="0" class="form-control" id="rank" value="{{ @$entrance->payload['rank'] }}" name="payload[rank]">
                              <div class="invalid-feedback">
                                 {{ __('required_field') }} {{ __('field_grade') }}
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