    <!-- create modal content -->
    <div id="editBankInfoModal-{{ @$bank_detail->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="needs-validation" novalidate action="{{ route('admin.user-bank.update',@$bank_detail->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$student->full_name}} {{ __('field_bank_information') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                       <div class="row">
                          <div class="col-md-12">
                             <fieldset class="row scheduler-border">
                                <div class="col-md-6">
                                   <label for="bank_name">{{ __('Bank') }}<span>*</span></label>
                                   <select class="form-control" name="bank_name" id="bank_name" required>
                                      <option value="">{{ __('select') }}</option>
                                      @foreach ($banks_name as $key => $bank)
                                        <option value="{{$bank->name}}"
                                          @if (isset($bank_detail) && $bank_detail->payload['bank_name'] == $bank->name) selected @endif>{{ $bank->name }}</option>
                                      @endforeach
                                   </select>
                                   <div class="invalid-feedback"> {{ __('Banks') }}
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                      <label for="phone" class="control-label">{{ 'Account Holder Name' }}<span>*</span></label>
                                      <input required name="account_holder_name"  type="text" pattern="[a-zA-Z]+.*"
                                         title="Please enter first letter alphabet and at least one alphabet character ."class="form-control"value="{{ @$bank_detail->payload['account_holder_name'] }}"
                                         placeholder="Enter Account Holder Name">
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group {{ $errors->has('account_no') ? 'has-error' : '' }}">
                                      <label for="account_no" class="control-label">{{ 'Account Number' }}<span>*</span></label>
                                      <input name="account_no" required type="number" min="0"
                                         class="form-control " value="{{ @$bank_detail->payload['account_no'] }}" placeholder="Enter Account Number">
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group {{ $errors->has('ifsc_code') ? 'has-error' : '' }}">
                                      <label for="ifsc_code" class="control-label">
                                      {{ 'IFSC Code' }}<span>*</span></label>
                                      <input   type="text" pattern="[a-zA-Z]+.*"
                                         title="Please enter first letter alphabet and at least one alphabet character is required." required name="ifsc_code" id="ifsc_code" class="form-control " placeholder="Enter Ifsc Code"value="{{ @$bank_detail->payload['ifsc_code'] }}">
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                                      <label for="branch" class="control-label">Branch<span>*</span></label>
                                      <input name="branch"  type="text" pattern="[a-zA-Z]+.*"
                                         title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control"
                                         placeholder="Enter Branch"value="{{ @$bank_detail->payload['branch'] }}" required>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <label for="" class="control-label">Account Type<span>*</span></label>
                                   <div class="form-check ">
                                      <input name="type" value="Current" type="radio" class="form-check-input pb-1" id="current" @if(@$bank_detail->payload['type'] == "Current")checked @endif>
                                      <label class="form-check-label pl-2 mb-1 " for="current">Current</label>
                                   </div>
                                   <div class="form-check mb-2">
                                      <input name="type" value="Saving" type="radio" class="form-check-input pb-1" id="saving"@if(@$bank_detail->payload['type'] == "Saving")checked @endif>
                                      <label class="form-check-label pl-2 mb-1 " for="saving">Saving</label>
                                   </div>
                                </div>
                             </fieldset>
                          </div>
                       </div>
                       <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>