
    <!-- create modal content -->
    <div id="createpatent-{{ Auth::user()->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/patent') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Patent </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                     <fieldset class="row">
                        {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Staff Id<span>*</span></label>
                            <input type="text" class="form-control " name="staff_id" id="staff_id" value="" required>
                         </div> --}}

                        <div class="form-group col-md-6">
                            <label for="membership_id">Patent Application No<span>*</span></label>
                            <input type="text" class="form-control " name="patent_application_no" id="patent_application_no" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Status Of Patent<span>*</span></label>
                            <input type="text" class="form-control " name="status_of_patent" id="status_of_patent" value="" required>
                            {{-- <span>separate names with ','</span> --}}
                         </div>

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Department<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_paper" id="title_of_paper" value="" required>
                         </div> --}}

                         <div class="form-group col-md-6">
                            <label for="membership_id">Patent Inventor<span>*</span></label>
                            <input type="text" class="form-control " name="patent_inventor" id="patent_inventor" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Title Of Patent<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_patent" id="title_of_patent" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Patent Applicant<span>*</span></label>
                            <input type="text" class="form-control " name="patent_applicant" id="patent_applicant" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Patent Published Date<span>*</span></label>
                            <input type="date" class="form-control date" name="patent_published_date" id="patent_published_date" value="" required>
                           </div>


                         <div class="form-group col-md-6">
                            <label for="membership_id">Link<span>*</span></label>
                            <input type="text" class="form-control " name="link" id="link" value="" required>
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
