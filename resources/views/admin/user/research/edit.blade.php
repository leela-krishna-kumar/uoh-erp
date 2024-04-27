    <!-- create modal content -->
    <div id="editResearchModal-{{ $research->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.research.update',$research->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ @$research->user_id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$row->full_name}} {{ __('field_research') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                     <fieldset class="row">
                        <div class="form-group col-md-6">
                            <label for="vidwan_id">Vidwan Id<span>*</span></label>
                            <input type="text" class="form-control " name="vidwan_id" id="vidwan_id" value="{{ @$research->vidwan_id }}"  >
                           
                         </div>
                         <div class="form-group col-md-6">
                             <label for="orcid_id">Orcid Id<span>*</span></label>
                             <input type="text" class="form-control " name="orcid_id" id="orcid_id" value="{{ @$research->orcid_id }}"  >
                             
                         </div>
                         <div class="form-group col-md-6">
                             <label for="researcher_id">Researcher Id<span>*</span></label>
                             <input type="text" class="form-control " name="researcher_id" id="researcher_id" value="{{ @$research->researcher_id }}"  >
                            
                         </div>
                         <div class="form-group col-md-6">
                         <label for="scopus_id">Scopus Id<span>*</span></label>
                         <input type="text" class="form-control " name="scopus_id" id="scopus_id" value="{{ @$research->scopus_id }}"  >
                         
                         </div>
                         <div class="form-group col-md-6">
                         <label for="google_scholar_id">Google Scholar Id<span>*</span></label>
                         <input type="text" class="form-control " name="google_scholar_id" id="google_scholar_id" value="{{ @$research->google_scholar_id }}"  >
                        
                        </div>

                        <div class="form-group col-md-6">
                            <label for="google_scholar_id">WOS Id<span>*</span></label>
                            <input type="text" class="form-control " name="wos_id" id="wos_id" value="{{ @$research->wos_id }}"  >
                           
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