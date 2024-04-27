
    <!-- create modal content -->
    <div id="editpatent-{{ $patent->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/patent/' . $patent->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Patent</h5>
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

                        {{-- <div class="form-group col-md-6">
                            <label for="membership_id">Staff Id<span>*</span></label>
                            <input type="text" class="form-control " name="staff_id" id="staff_id" value="" required>
                         </div> --}}

                        <div class="form-group col-md-6">
                            <label for="membership_id">Patent Application No<span>*</span></label>
                            <input type="text" class="form-control " name="patent_application_no" id="patent_application_no" value="{{ @$patent->patent_application_no }}" required>
                         </div>

                         {{-- @php
                         $name_of_the_author = json_decode($journal->name_of_the_author);
                        @endphp --}}
{{--
                         <div class="form-group col-md-6">
                            <label for="membership_id">Status Of Patent<span>*</span></label>
                            <input type="text" class="form-control " name="status_of_patent" id="status_of_patent" value="{{ implode(',' , $status_of_patent)}}" required>
                            <span>separate names with ','</span>
                         </div> --}}

                         <div class="form-group col-md-6">
                            <label for="membership_id">Status Of Patent<span>*</span></label>
                            <input type="text" class="form-control " name="status_of_patent" id="status_of_patent" value="{{ @$patent->status_of_patent}}" required>
                            {{-- <span>separate names with ','</span> --}}
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Patent Inventor<span>*</span></label>
                            <input type="text" class="form-control " name="patent_inventor" id="patent_inventor" value="{{ @$patent->patent_inventor }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Title Of Patent<span>*</span></label>
                            <input type="text" class="form-control " name="title_of_patent" id="title_of_patent" value="{{ @$patent->title_of_patent }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Patent Applicant<span>*</span></label>
                            <input type="text" class="form-control " name="patent_applicant" id="patent_applicant" value="{{ @$patent->patent_applicant }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Patent Published Date<span>*</span></label>
                            <input type="date" class="form-control " name="patent_published_date" id="patent_published_date" value="{{ @$patent->patent_published_date }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id"> Link<span>*</span></label>
                            <input type="text" class="form-control " name="link" id="link" value="{{ @$patent->link }}" required>
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
