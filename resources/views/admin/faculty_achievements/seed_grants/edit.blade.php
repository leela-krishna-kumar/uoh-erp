
    <!-- create modal content -->
    <div id="editseed_grant-{{ $seed_grant->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/seed-grants/' . $seed_grant->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} seed_grants </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       
                     <fieldset class="row">
                                               
                        <div class="form-group col-md-6">
                            <label for="membership_id">Application Number<span>*</span></label>
                            <input type="text" class="form-control " name="application_no" id="application_no" value="{{ @$seed_grant->application_no }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Title<span>*</span></label>
                            <input type="text" class="form-control " name="title" id="title" value="{{ @$seed_grant->title }}" required>
                         </div>

                         @php
                         $pi = json_decode($seed_grant->pi);
                        @endphp

                         <div class="form-group col-md-6">
                            <label for="membership_id">PIs<span>*</span></label>
                            <input type="text" class="form-control " name="pi" id="pi" value="{{ implode(',' , $pi)}}" required>
                            <span>separate names with ','</span>
                         </div>

                         @php
                         $co_pi = json_decode($seed_grant->co_pi);
                        @endphp

                         <div class="form-group col-md-6">
                            <label for="membership_id">CO PIs<span>*</span></label>
                            <input type="text" class="form-control " name="co_pi" id="co_pi" value="{{ implode(',' , $co_pi)}}" required>
                            <span>separate names with ','</span>
                         </div>
    
                         <div class="form-group col-md-6">
                            <label for="membership_id">Duration in Months<span>*</span></label>
                            <input type="text" class="form-control " name="duration_in_months" id="duration_in_months" value="{{ @$seed_grant->duration_in_months }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Scope<span>*</span></label>
                            <input type="text" class="form-control " name="scope" id="scope" value="{{ @$seed_grant->scope }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Research Area<span>*</span></label>
                            <input type="text" class="form-control " name="research_area" id="research_area" value="{{ @$seed_grant->research_area }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Amount in Rupees<span>*</span></label>
                            <input type="text" class="form-control " name="amount_in_rupees" id="amount_in_rupees" value="{{ @$seed_grant->amount_in_rupees }}" required>
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
