<!-- create modal content -->
<div id="createprofession-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate action="{{ route('admin.professional-body.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $row->id }}">
                <input type="hidden" name="staff_id" value="{{ $row->staff_id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{$row->full_name}} Professional Body </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <fieldset class="row">
                        <div class="form-group col-md-6" id="profession_id">
                            <label for="profession_id">Select Membership<span>*</span></label>
                            <select class="form-control" name="profession_id" id="sprofession_id" required onchange="professionIdFunction(this)">
                                <option value="">{{ __('select') }}</option>
                                <option value="0">IEEE</option>
                                <option value="1">IETE</option>
                                <option value="2">ISTE</option>
                                <option value="3">CSI</option>
                                <option value="4">IEI</option>
                                <option value="5">ACE</option>
                                <option value="6">others</option>
                            </select>

                            <div class="invalid-feedback"> {{ __('field_status') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6" id="othersMembershipTypeDiv" style="display: block;">
                            <label for="others_membership_type">Enter Membership Type<span>*</span></label>
                            <input type="text" class="form-control" name="others_membership_type" value="{{ old('others_membership_type') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="membership_id">Enter Membership ID<span>*</span></label>
                            <input type="text" class="form-control " name="membership_id" id="membership_id" value="" required>
                        </div>
                        <div class="form-group col-md-6" id="idCard">
                            <label for="membership_file">Id Card<span>*</span></label>
                            <input type="file" class="form-control" name="idcard" id="" required>
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

<script src="{{ asset('dashboard/plugins/jquery/js/jquery.min.js') }}"></script>


<script type="text/javascript">
    function professionIdFunction(select) {
        var value = select.value;
        alert(value);
        if (value == 6) {
            document.getElementById('othersMembershipTypeDiv').style.display = 'block';
            alert(document.getElementById("othersMembershipTypeDiv").style.display);
        } else {
            document.getElementById('othersMembershipTypeDiv').style.display = 'none';
            alert(document.getElementById("othersMembershipTypeDiv").style.display);
        }
    }
</script>