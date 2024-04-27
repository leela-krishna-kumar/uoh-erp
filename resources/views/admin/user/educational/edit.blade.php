    <!-- create modal content -->
    <div id="editEducationalModal-{{ $education->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.education.update', $education->id) }}"
                    method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $row->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ $row->full_name }} {{ __('tab_educational_info') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <fieldset class="row">
                            <div class="form-group col-md-12">
                                <label
                                    for="graduation_academy">{{ __('field_graduation_academy') }}<span>*</span></label>
                                <input required type="text" class="form-control" name="payload[graduation_academy]"
                                    id="graduation_academy" value="{{ @$education->payload['graduation_academy'] }}">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_graduation_academy') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    for="year_of_graduation">{{ __('field_year_of_graduation') }}<span>*</span></label>
                                <input required type="text" class="form-control autonumber"
                                    name="payload[year_of_graduation]" id="year_of_graduation"
                                    value="{{ @$education->payload['year_of_graduation'] }}">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_year_of_graduation') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="graduation_field">{{ __('field_graduation_field') }}<span>*</span></label>
                                <input required type="text" class="form-control" name="payload[graduation_field]"
                                    id="graduation_field" value="{{ @$education->payload['graduation_field'] }}">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_graduation_field') }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="education_level">{{ __('field_education_level') }}<span>*</span></label>
                                <select class="form-control" required class="form-control"
                                    name="payload[education_level]" id="education_level"
                                    value="{{ @$education->education_type }}">
                                    <option value="" {{ $education->education_type == '' ? 'selected' : '' }}>
                                        {{ __('select') }}</option>
                                    <option value="SSC" {{ $education->education_type == 'SSC' ? 'selected' : '' }}>
                                        SSC</option>
                                    <option value="Inter"
                                        {{ $education->education_type == 'Inter' ? 'selected' : '' }}>Inter</option>
                                    <option value="Diploma"
                                        {{ $education->education_type == 'Diploma' ? 'selected' : '' }}>Diploma
                                    </option>
                                    <option value="UG" {{ $education->education_type == 'UG' ? 'selected' : '' }}>
                                        UG</option>
                                    <option value="PG" {{ $education->education_type == 'PG' ? 'selected' : '' }}>
                                        PG</option>
                                    <option value="Ph.D"
                                        {{ $education->education_type == 'Ph.D' ? 'selected' : '' }}>Ph.D</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_education_level') }}
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="note">{{ __('field_note') }}</label>
                                <textarea class="form-control" name="payload[note]" id="note">{{ @$education->payload['note'] }}</textarea>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_note') }}
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-times"></i> {{ __('btn_close') }}</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                            {{ __('btn_save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
