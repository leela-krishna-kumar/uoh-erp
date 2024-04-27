
    <!-- create modal content -->
    <div id="createawards-{{ Auth::user()->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/awards') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Awards </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                     <fieldset class="row">

                        {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Staff Id<span>*</span></label>
                            <input type="text" class="form-control " name="staff_id" id="staff_id" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Faculty Name<span>*</span></label>
                            <input type="text" class="form-control " name="faculty_name" id="faculty_name" value="" required>
                         </div> --}}

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Department<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_paper" id="title_of_paper" value="" required>
                         </div> --}}

                         <div class="form-group col-md-6">
                            <label for="membership_id">Award Name<span>*</span></label>
                            <input type="text" class="form-control " name="award_name" id="award_name" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Awarding Agency<span>*</span></label>
                            <input type="text" class="form-control " name="awarding_agency" id="awarding_agency" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Date<span>*</span></label>
                            <input type="date" class="form-control " name="date" id="date" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Image<span>*</span></label>
                            <input type="file" class="form-control " name="image" id="" required>
                         </div>



                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Link<span>*</span></label>
                            <input type="text" class="form-control " name="link" id="link" value="" required>
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
