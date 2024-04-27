    <!-- create modal content -->
    <div id="editProfesionModal-{{ $profession->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.professional-body.update',$profession->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ @$profession->user_id }}">
                    <input type="hidden" name="profesion_model_id" value="{{ @$profession->id }}">
                    <input type="hidden" name="attach" value="{{ @$profession->attach }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$row->full_name}} Professional Body </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                     <fieldset class="row">
                        <div class="form-group col-md-6">
                            <label for="profession_id">Select Membership<span>*</span></label>
                            <select class="form-control" name="profession_id" id="profession_id" required>
                                <option value="">{{ __('select') }}</option>
                                <option value="0" {{ $profession->profession_id == 0 ? 'selected' : '' }}>IEEE</option>
                                <option value="1" {{ $profession->profession_id == 1 ? 'selected' : '' }}>IETE</option>
                                <option value="2" {{ $profession->profession_id == 2 ? 'selected' : '' }}>ISTE</option>
                                <option value="3" {{ $profession->profession_id == 3 ? 'selected' : '' }}>CSI</option>
                                <option value="4" {{ $profession->profession_id == 4 ? 'selected' : '' }}>IEI</option>
                                <option value="5" {{ $profession->profession_id == 5 ? 'selected' : '' }}>ACE</option>
                                <option value="6" {{ $profession->profession_id == 6 ? 'selected' : '' }}>others</option>
                            </select>
                            <div class="invalid-feedback"> {{ __('field_status') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6" id="othersMembershipTypeDiv">
                            <label for="others_membership_type">Enter Membership Type<span>*</span></label>
                            <input type="text" class="form-control" name="others_membership_type" value="{{ @$profession->others_membership_type }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="membership_id">Enter Membership ID<span>*</span></label>
                            <input type="text" class="form-control " name="membership_id" id="membership_id" value="{{ @$profession->membership_id }}" required>

                         </div>

                         <input type="hidden" name="idcard" value="{{ @$profession->idcard }}" required>


                         <div class="form-group col-md-6">
                             <label for="membership_file">Id Card<span>*</span></label>
                             <input type="file" class="form-control" name="idcard">
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

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var othersMembershipTypeDiv = document.getElementById('othersMembershipTypeDiv');
            if (othersMembershipTypeDiv) {
                othersMembershipTypeDiv.style.display = 'none';
            }
            document.getElementById('profession_id').addEventListener('change', function() {
                var professionId = this.value;
                if (professionId === '6') {
                    othersMembershipTypeDiv.style.display = 'block';
                    othersMembershipTypeDiv.setAttribute('required', 'required');
                } else {
                    othersMembershipTypeDiv.style.display = 'none';
                }
            });
        });
    </script>