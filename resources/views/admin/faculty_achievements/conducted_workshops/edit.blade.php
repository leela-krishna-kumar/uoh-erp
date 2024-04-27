
    <!-- create modal content -->
    <div id="editworkshop-{{ $workshop->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/workshops-attended/' . $workshop->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} workshops-conducted </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       
                        <fieldset class="row">
                                                
                            <div class="form-group col-md-6">
                                <label for="membership_id">Workshop Name<span>*</span></label>
                                <input type="text" class="form-control " name="workshop_name" id="title_of_paper" value="{{ old('workshop_name', $workshop->workshop_name) }}" required>
                             </div>

                             <div class="form-group col-md-6">
                                <label for="workshop_type">Workshop Type</label>
                                <select class="form-control" required name="workshop_type" id="workshop_type">
                                    <option value="">Select</option>
                                    <option value="Workshop" {{ $workshop->workshop_type == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="FDP" {{ $workshop->workshop_type == 'FDP' ? 'selected' : '' }}>FDP</option>
                                    <option value="PDP" {{ $workshop->workshop_type == 'PDP' ? 'selected' : '' }}>PDP</option>
                                    <option value="Orientation Program" {{ $workshop->workshop_type == 'Orientation Program' ? 'selected' : '' }}>Orientation Program</option>
                                    <option value="Seminar" {{ $workshop->workshop_type == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="NPTEL" {{ $workshop->workshop_type == 'NPTEL' ? 'selected' : '' }}>NPTEL</option>
                                    <option value="Conference" {{ $workshop->workshop_type == 'Conference' ? 'selected' : '' }}>Conference</option>
                                </select>
                            </div>
                            
    
                             <div class="form-group col-md-6">
                                <label for="membership_id">Number Of Participants<span>*</span></label>
                                <input type="text" class="form-control " name="no_of_participants" id="name_of_the_author" value="{{ old('no_of_participants', $workshop->no_of_participants) }}" required>
                             </div>
                            
                             <div class="form-group col-md-6">
                                <label for="membership_id">From Date<span>*</span></label>
                                <input type="date" class="form-control " name="from_date" id="from_date" value="{{ @$workshop->from_date }}" required>
                             </div>
    
                             <div class="form-group col-md-6">
                                <label for="membership_id">To Date</label>
                                <input type="date" class="form-control " name="to_date" id="date" value="{{ @$workshop->to_date }}">
                             </div>
    
                             <div class="form-group col-md-6">
                            </div>
    
                            <div class="form-group col-md-3 mt-4">
                                <label for="membership_id">Brochure</label>
                            </div>
    
                            <div class="form-group col-md-4">
                                <label for="membership_id">Link</label>
                                <input type="text" class="form-control " name="brochure_link"value="{{ old('brochure_link', $workshop->brochure_link) }}">
                            </div>

                            <input type="hidden" name="brochure_attach" value="{{ @$workshop->brochure_attach }}" required>

                            <div class="form-group col-md-5">
                                <label for="membership_id">Upload</label>
                                <input type="file" class="form-control " name="brochure_attach" id="">
                            </div>
    
                            <div class="form-group col-md-3 mt-4">
                                <label for="membership_id">Certificate</label>
                            </div>
    
                            <div class="form-group col-md-4">
                                <label for="membership_id">Link</label>
                                <input type="text" class="form-control" name="certificate_link"value="{{ old('certificate_link', $workshop->certificate_link) }}">
                            </div>
                            <input type="hidden" name="certificate_attach" value="{{ @$workshop->certificate_attach }}" required>

                            <div class="form-group col-md-5">
                                <label for="membership_id">Upload</label>
                                <input type="file" class="form-control" name="certificate_attach" id="">
                            </div>
    
                            <div class="form-group col-md-3 mt-4">
                                <label for="membership_id">Schedule</label>
                            </div>
    
                            <div class="form-group col-md-4">
                                <label for="membership_id">Link</label>
                                <input type="text" class="form-control " name="schedule_link"value="{{ old('schedule_link', $workshop->schedule_link) }}">
                            </div>

                            <input type="hidden" name="schedule_attach" value="{{ @$workshop->schedule_attach }}" required>

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
