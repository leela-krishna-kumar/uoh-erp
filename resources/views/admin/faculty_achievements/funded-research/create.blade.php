
    <!-- create modal content -->
    <div id="createFundedResearch-{{ Auth::user()->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/funded-research') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Funded Research </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                     <fieldset class="row">

                        <div class="form-group col-md-6">
                            <label for="pi_or_co_pi_name">Name of the Principal Investigator/ Co Investigator<span>*</span></label>
                            <input type="text" class="form-control " name="pi_or_co_pi_name" id="pi_or_co_pi_name" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="funding_agency">Name of the Funding agency<span>*</span></label>
                            <input type="text" class="form-control " name="funding_agency" id="funding_agency" value="" required>
                         </div>


                         <div class="form-group col-md-6">
                            <label for="sponsord_project">Title of the Sponsored Project<span>*</span></label>
                            <input type="text" class="form-control " name="sponsord_project" id="sponsord_project" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="funds_provided">Funds provided<span>*</span></label>
                            <input type="number" class="form-control " name="funds_provided" id="funds_provided" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="grant_month_year">Month & Year of Receiving the grant<span>*</span></label>
                            <input type="month" class="form-control " name="grant_month_year" id="grant_month_year" value="" required>
                            {{-- <span>separate month and year with '-'</span> --}}
                         </div>

                         <div class="form-group col-md-6">
                            <label for="project_duration">Duration of the project<span>*</span></label>
                            <input type="number" class="form-control " name="project_duration" id="project_duration" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="type">Type<span>*</span></label>
                            <input type="text" class="form-control " name="type" id="type" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="status">Status<span>*</span></label>
                            <input type="text" class="form-control " name="status" id="status" value="" required>
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
