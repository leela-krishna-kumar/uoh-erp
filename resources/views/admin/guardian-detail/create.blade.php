    <!-- create modal content -->
    <div id="createGuardianModal-{{ $student->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.guardian-detail.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="student_id" value="{{$student->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{$student->full_name}} {{ __('field_guardians_information') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <fieldset class="row">
                            <div class="form-group col-md-6">
                                <label for="guardian_name">{{ __('Name') }}<span>*</span></label>
                                <input type="text" class="form-control" name="guardian_name" id="guardian_name" value="{{ old('guardian_name') }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('guardian_name') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('email') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="relation" class="form-label">{{ __('field_relation') }}<span>*</span></label>
                                <select class="form-control" name="relation_id" id="relation_id">
                                @foreach ($relations as $key => $relation)
                                    <option value="{{$relation->id}}">{{$relation->name}}</option>
                                @endforeach
                                </select>
                                <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_relation') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardian_phone">{{ __('Phone') }}</label>
                                <input type="number" class="form-control" min="0" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone') }}">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('guardian_phone') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="occupation">{{ __('Occupation') }}</label>
                                <input type="text" class="form-control" name="occupation" id="occupation" value="{{ old('occupation') }}">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('occupation') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="annual_income">{{ __('Annual Income') }}(in ₹)<span>*</span></label>
                                <!-- <input type="number" class="form-control" name="annual_income" id="annual_income" value="{{ old('annual_income') ?? 0 }}" min="0" required> -->
                                <select name="annual_income" id="annual_income" class="form-control">
                                    @foreach(getAnnualIncomeType() as $type)
                                       <option value="{{$type['id']}}">{{$type['name']}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('annual_income') }}
                                </div>
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