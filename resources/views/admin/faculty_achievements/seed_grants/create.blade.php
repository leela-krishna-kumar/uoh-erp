
    <!-- create modal content -->
    <div id="createseed_grant-{{ Auth::user()->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/seed-grants') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Seed Grant </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       
                     <fieldset class="row">
                                                
                        <div class="form-group col-md-6">
                            <label for="membership_id">Application Number<span>*</span></label>
                            <input type="text" class="form-control " name="application_no" id="application_no" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Title<span>*</span></label>
                            <input type="text" class="form-control " name="title" id="title" value="" required>
                         </div>

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Department<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_paper" id="title_of_paper" value="" required>
                         </div> --}}

                         <div class="form-group col-md-6">
                            <label for="membership_id">PIs<span>*</span></label>
                            <input type="text" class="form-control " name="pi" id="pi" value="" required>
                            <span>separate names with ','</span>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Co PIs<span>*</span></label>
                            <input type="text" class="form-control " name="co_pi" id="co_pi" value="" required>
                            <span>separate names with ','</span>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Duration in Months<span>*</span></label>
                            <input type="text" class="form-control " name="duration_in_months" id="duration_in_months" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Scope<span>*</span></label>
                            <input type="text" class="form-control " name="scope" id="scope" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Research Area<span>*</span></label>
                            <input type="text" class="form-control " name="research_area" id="research_area" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                           <label for="membership_id">Amount in Rupees<span>*</span></label>
                           <input type="text" class="form-control " name="amount_in_rupees" id="amount_in_rupees" value="" required>
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
