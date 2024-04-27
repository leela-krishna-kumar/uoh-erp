
    <!-- create modal content -->
    <div id="editawards-{{ $awards->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ url('admin/faculty-achievements/awards/' . $awards->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <input type="hidden" name="staff_id" value="{{ $row->staff_id }}"> --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ Auth::user()->full_name}} Awards</h5>
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
                            <label for="membership_id">Award Name<span>*</span></label>
                            <input type="text" class="form-control " name="award_name" id="award_name" value="{{ @$awards->award_name }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Awarding Agency<span>*</span></label>
                            <input type="text" class="form-control " name="awarding_agency" id="awarding_agency" value="{{ @$awards->awarding_agency }}" required>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Date<span>*</span></label>
                            <input type="date" class="form-control " name="date" id="date" value="{{ @$awards->date }}" required>
                         </div>
                         <input type="hidden" name="image" value="{{ @$awards->image }}" required>

                         <div class="form-group col-md-6">
                            <label for="membership_id">Image<span>*</span></label>
                            <input type="file" class="form-control " name="image" id="">
                         </div>

                         {{-- <div class="form-group col-md-6">
                            <label for="membership_id"> Link<span>*</span></label>
                            <input type="text" class="form-control " name="link" id="link" value="{{ @$patent->link }}" required>
                         </div> --}}

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
