
    <!-- create modal content -->
    <div id="editjournal-{{ $journal->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/journals/' . $journal->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Journals </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                     <fieldset class="row">
                        {{-- <div class="form-group col-md-6">
                            <label for="profession_id">Select Membership<span>*</span></label>
                            <select class="form-control" name="profession_id" id="profession_id" required>
                                <option value="">{{ __('select') }}</option>
                                @php
                                    $existed_ids = App\Models\ProfessionalBody::where('user_id', $row->id)->pluck('profession_id')->toArray();
                                @endphp
                                @foreach([0 => 'IEEE', 1 => 'IETE', 2 => 'ISTE', 3 => 'CSI', 4 => 'IEI'] as $value => $label)
                                    @if (!in_array($value, $existed_ids))
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <div class="invalid-feedback"> {{ __('field_status') }}
                            </div>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label for="membership_id">Title of paper<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_paper" id="title_of_paper" value="{{ @$journal->title_of_paper }}" required>
                         </div>

                         @php
                         $name_of_the_author = json_decode($journal->name_of_the_author);
                        @endphp

                         <div class="form-group col-md-6">
                            <label for="membership_id">Name of the author/s<span>*</span></label>
                            <input type="text" class="form-control " name="name_of_the_author" id="name_of_the_author" value="{{ implode(',' , $name_of_the_author)}}" required>
                            <span>separate names with ','</span>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Name of the journal<span>*</span></label>
                            <input type="text" class="form-control " name="name_of_the_journal" id="name_of_the_journal" value="{{ @$journal->name_of_the_journal }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Year of publication<span>*</span></label>
                            <input type="text" class="form-control " name="year_of_publication" id="title_of_paper" value="{{ @$journal->year_of_publication }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">ISSN Number<span>*</span></label>
                            <input type="text" class="form-control " name="issn_number" id="issn_number" value="{{ @$journal->issn_number }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Journal Website Link<span>*</span></label>
                            <input type="text" class="form-control " name="journal_website_link" id="journal_website_link" value="{{ @$journal->journal_website_link }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Paper Abstract Article Link<span>*</span></label>
                            <input type="text" class="form-control " name="paper_abstract_article_link" id="paper_abstract_article_link" value="{{ @$journal->paper_abstract_article_link }}" required>
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
