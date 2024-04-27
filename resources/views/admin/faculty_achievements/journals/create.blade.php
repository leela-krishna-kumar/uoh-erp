
    <!-- create modal content -->
    <div id="createjournal-{{ Auth::user()->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/journals') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Journals </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       
                     <fieldset class="row">
                                                
                        <div class="form-group col-md-6">
                            <label for="membership_id">Title of paper<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_paper" id="title_of_paper" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Name of the author/s<span>*</span></label>
                            <input type="text" class="form-control " name="name_of_the_author" id="name_of_the_author" value="" required>
                            <span>separate names with ','</span>
                         </div>

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Department<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_paper" id="title_of_paper" value="" required>
                         </div> --}}

                         <div class="form-group col-md-6">
                            <label for="membership_id">Name of the journal<span>*</span></label>
                            <input type="text" class="form-control " name="name_of_the_journal" id="name_of_the_journal" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Year of publication<span>*</span></label>
                            <input type="text" class="form-control " name="year_of_publication" id="title_of_paper" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">ISSN Number<span>*</span></label>
                            <input type="text" class="form-control " name="issn_number" id="issn_number" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Journal Website Link<span>*</span></label>
                            <input type="text" class="form-control " name="journal_website_link" id="journal_website_link" value="" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Paper Abstract Article Link<span>*</span></label>
                            <input type="text" class="form-control " name="paper_abstract_article_link" id="paper_abstract_article_link" value="" required>
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
