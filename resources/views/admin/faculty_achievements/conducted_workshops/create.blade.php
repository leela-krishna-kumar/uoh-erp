
    <div id="createworkshop-{{ Auth::user()->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/workshops-attended') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Workshops Attended</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                     <fieldset class="row">

                        <div class="form-group col-md-6">
                            <label for="membership_id">Workshop Name<span>*</span></label>
                            <input type="text" class="form-control " name="workshop_name" id="title_of_paper" value="" required>
                         </div>

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Workshop Type<span>*</span></label>
                            <input type="text" class="form-control " name="workshop_type" value="" required>
                         </div> --}}

                         <div class="form-group col-md-6">
                            <label for="membership_id">Workshop Type<span>*</span></label>
                            <select class="form-control" required name="workshop_type">
                                <option value="" selected>{{ __('Select') }}</option>
                                <option value="Workshop">Workshop</option>
                                <option value="FDP">FDP</option>
                                <option value="PDP">PDP</option>
                                <option value="Orientation Program">Orientation Program</option>
                                <option value="Seminar">Seminar</option>
                                <option value="NPTEL">NPTEL</option>
                                <option value="Conference">Conference</option>
                            </select>
                        </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Number Of Participants<span>*</span></label>
                            <input type="number" class="form-control " name="no_of_participants" id="name_of_the_author" value="" required>
                            {{-- <span>separate names with ','</span> --}}
                         </div>
                         <div class="form-group col-md-6">
                            <label for="membership_id">From Date<span>*</span></label>
                            <input type="date" class="form-control date" name="from_date" id="dob" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">To Date</label>
                            <input type="date" class="form-control date" name="to_date" id="dob" value="" required>
                         </div>

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Link<span>*</span></label>
                            <input type="text" class="form-control " name="link" id="issn_number" value="" required>
                         </div> --}}

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">From Year<span>*</span></label>
                            <input type="text" class="form-control " name="from_year" id="journal_website_link" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">To Year<span>*</span></label>
                            <input type="text" class="form-control " name="to_year" id="journal_website_link" value="" required>
                         </div> --}}

                        <div class="form-group col-md-6">
                        </div>

                        <div class="form-group col-md-3 mt-4">
                            <label for="membership_id">Brochure</label>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="membership_id">Link</label>
                            <input type="text" class="form-control " name="brochure_link"value="">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="membership_id">Upload</label>
                            <input type="file" class="form-control " name="brochure_attach" id="">
                        </div>

                        <div class="form-group col-md-3 mt-4">
                            <label for="membership_id">Certificate</label>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="membership_id">Link</label>
                            <input type="text" class="form-control" name="certificate_link"value="">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="membership_id">Upload</label>
                            <input type="file" class="form-control" name="certificate_attach" id="">
                        </div>

                        <div class="form-group col-md-3 mt-4">
                            <label for="membership_id">Schedule</label>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="membership_id">Link</label>
                            <input type="text" class="form-control " name="schedule_link"value="">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="membership_id">Upload</label>
                            <input type="file" class="form-control " name="schedule_attach" id="">
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
